<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($estado_actual_legajo_persona_grid)) $estado_actual_legajo_persona_grid = new cestado_actual_legajo_persona_grid();

// Page init
$estado_actual_legajo_persona_grid->Page_Init();

// Page main
$estado_actual_legajo_persona_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_actual_legajo_persona_grid->Page_Render();
?>
<?php if ($estado_actual_legajo_persona->Export == "") { ?>
<script type="text/javascript">

// Form object
var festado_actual_legajo_personagrid = new ew_Form("festado_actual_legajo_personagrid", "grid");
festado_actual_legajo_personagrid.FormKeyCountName = '<?php echo $estado_actual_legajo_persona_grid->FormKeyCountName ?>';

// Validate form
festado_actual_legajo_personagrid.Validate = function() {
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
festado_actual_legajo_personagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Matricula", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Certificado_Pase", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tiene_DNI", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Certificado_Medico", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Posee_Autorizacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cooperadora", false)) return false;
	return true;
}

// Form_CustomValidate event
festado_actual_legajo_personagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_actual_legajo_personagrid.ValidateRequired = true;
<?php } else { ?>
festado_actual_legajo_personagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_actual_legajo_personagrid.Lists["x_Matricula"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Matricula"].Options = <?php echo json_encode($estado_actual_legajo_persona->Matricula->Options()) ?>;
festado_actual_legajo_personagrid.Lists["x_Certificado_Pase"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Certificado_Pase"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Pase->Options()) ?>;
festado_actual_legajo_personagrid.Lists["x_Tiene_DNI"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Tiene_DNI"].Options = <?php echo json_encode($estado_actual_legajo_persona->Tiene_DNI->Options()) ?>;
festado_actual_legajo_personagrid.Lists["x_Certificado_Medico"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Certificado_Medico"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Medico->Options()) ?>;
festado_actual_legajo_personagrid.Lists["x_Posee_Autorizacion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Posee_Autorizacion"].Options = <?php echo json_encode($estado_actual_legajo_persona->Posee_Autorizacion->Options()) ?>;
festado_actual_legajo_personagrid.Lists["x_Cooperadora"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personagrid.Lists["x_Cooperadora"].Options = <?php echo json_encode($estado_actual_legajo_persona->Cooperadora->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($estado_actual_legajo_persona->CurrentAction == "gridadd") {
	if ($estado_actual_legajo_persona->CurrentMode == "copy") {
		$bSelectLimit = $estado_actual_legajo_persona_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$estado_actual_legajo_persona_grid->TotalRecs = $estado_actual_legajo_persona->SelectRecordCount();
			$estado_actual_legajo_persona_grid->Recordset = $estado_actual_legajo_persona_grid->LoadRecordset($estado_actual_legajo_persona_grid->StartRec-1, $estado_actual_legajo_persona_grid->DisplayRecs);
		} else {
			if ($estado_actual_legajo_persona_grid->Recordset = $estado_actual_legajo_persona_grid->LoadRecordset())
				$estado_actual_legajo_persona_grid->TotalRecs = $estado_actual_legajo_persona_grid->Recordset->RecordCount();
		}
		$estado_actual_legajo_persona_grid->StartRec = 1;
		$estado_actual_legajo_persona_grid->DisplayRecs = $estado_actual_legajo_persona_grid->TotalRecs;
	} else {
		$estado_actual_legajo_persona->CurrentFilter = "0=1";
		$estado_actual_legajo_persona_grid->StartRec = 1;
		$estado_actual_legajo_persona_grid->DisplayRecs = $estado_actual_legajo_persona->GridAddRowCount;
	}
	$estado_actual_legajo_persona_grid->TotalRecs = $estado_actual_legajo_persona_grid->DisplayRecs;
	$estado_actual_legajo_persona_grid->StopRec = $estado_actual_legajo_persona_grid->DisplayRecs;
} else {
	$bSelectLimit = $estado_actual_legajo_persona_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($estado_actual_legajo_persona_grid->TotalRecs <= 0)
			$estado_actual_legajo_persona_grid->TotalRecs = $estado_actual_legajo_persona->SelectRecordCount();
	} else {
		if (!$estado_actual_legajo_persona_grid->Recordset && ($estado_actual_legajo_persona_grid->Recordset = $estado_actual_legajo_persona_grid->LoadRecordset()))
			$estado_actual_legajo_persona_grid->TotalRecs = $estado_actual_legajo_persona_grid->Recordset->RecordCount();
	}
	$estado_actual_legajo_persona_grid->StartRec = 1;
	$estado_actual_legajo_persona_grid->DisplayRecs = $estado_actual_legajo_persona_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$estado_actual_legajo_persona_grid->Recordset = $estado_actual_legajo_persona_grid->LoadRecordset($estado_actual_legajo_persona_grid->StartRec-1, $estado_actual_legajo_persona_grid->DisplayRecs);

	// Set no record found message
	if ($estado_actual_legajo_persona->CurrentAction == "" && $estado_actual_legajo_persona_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$estado_actual_legajo_persona_grid->setWarningMessage(ew_DeniedMsg());
		if ($estado_actual_legajo_persona_grid->SearchWhere == "0=101")
			$estado_actual_legajo_persona_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$estado_actual_legajo_persona_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$estado_actual_legajo_persona_grid->RenderOtherOptions();
?>
<?php $estado_actual_legajo_persona_grid->ShowPageHeader(); ?>
<?php
$estado_actual_legajo_persona_grid->ShowMessage();
?>
<?php if ($estado_actual_legajo_persona_grid->TotalRecs > 0 || $estado_actual_legajo_persona->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid estado_actual_legajo_persona">
<div id="festado_actual_legajo_personagrid" class="ewForm form-inline">
<?php if ($estado_actual_legajo_persona_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($estado_actual_legajo_persona_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_estado_actual_legajo_persona" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_estado_actual_legajo_personagrid" class="table ewTable">
<?php echo $estado_actual_legajo_persona->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$estado_actual_legajo_persona_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$estado_actual_legajo_persona_grid->RenderListOptions();

// Render list options (header, left)
$estado_actual_legajo_persona_grid->ListOptions->Render("header", "left");
?>
<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Matricula) == "") { ?>
		<th data-name="Matricula"><div id="elh_estado_actual_legajo_persona_Matricula" class="estado_actual_legajo_persona_Matricula"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Matricula->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Matricula"><div><div id="elh_estado_actual_legajo_persona_Matricula" class="estado_actual_legajo_persona_Matricula">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Matricula->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Matricula->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Matricula->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Certificado_Pase) == "") { ?>
		<th data-name="Certificado_Pase"><div id="elh_estado_actual_legajo_persona_Certificado_Pase" class="estado_actual_legajo_persona_Certificado_Pase"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Certificado_Pase->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Certificado_Pase"><div><div id="elh_estado_actual_legajo_persona_Certificado_Pase" class="estado_actual_legajo_persona_Certificado_Pase">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Certificado_Pase->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Certificado_Pase->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Certificado_Pase->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Tiene_DNI) == "") { ?>
		<th data-name="Tiene_DNI"><div id="elh_estado_actual_legajo_persona_Tiene_DNI" class="estado_actual_legajo_persona_Tiene_DNI"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Tiene_DNI->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tiene_DNI"><div><div id="elh_estado_actual_legajo_persona_Tiene_DNI" class="estado_actual_legajo_persona_Tiene_DNI">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Tiene_DNI->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Tiene_DNI->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Tiene_DNI->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Certificado_Medico) == "") { ?>
		<th data-name="Certificado_Medico"><div id="elh_estado_actual_legajo_persona_Certificado_Medico" class="estado_actual_legajo_persona_Certificado_Medico"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Certificado_Medico->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Certificado_Medico"><div><div id="elh_estado_actual_legajo_persona_Certificado_Medico" class="estado_actual_legajo_persona_Certificado_Medico">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Certificado_Medico->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Certificado_Medico->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Certificado_Medico->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Posee_Autorizacion) == "") { ?>
		<th data-name="Posee_Autorizacion"><div id="elh_estado_actual_legajo_persona_Posee_Autorizacion" class="estado_actual_legajo_persona_Posee_Autorizacion"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Posee_Autorizacion"><div><div id="elh_estado_actual_legajo_persona_Posee_Autorizacion" class="estado_actual_legajo_persona_Posee_Autorizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Posee_Autorizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Posee_Autorizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Cooperadora) == "") { ?>
		<th data-name="Cooperadora"><div id="elh_estado_actual_legajo_persona_Cooperadora" class="estado_actual_legajo_persona_Cooperadora"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Cooperadora->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cooperadora"><div><div id="elh_estado_actual_legajo_persona_Cooperadora" class="estado_actual_legajo_persona_Cooperadora">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Cooperadora->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Cooperadora->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Cooperadora->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_estado_actual_legajo_persona_Fecha_Actualizacion" class="estado_actual_legajo_persona_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_estado_actual_legajo_persona_Fecha_Actualizacion" class="estado_actual_legajo_persona_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_actual_legajo_persona->Usuario->Visible) { // Usuario ?>
	<?php if ($estado_actual_legajo_persona->SortUrl($estado_actual_legajo_persona->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_estado_actual_legajo_persona_Usuario" class="estado_actual_legajo_persona_Usuario"><div class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_estado_actual_legajo_persona_Usuario" class="estado_actual_legajo_persona_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_actual_legajo_persona->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_actual_legajo_persona->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_actual_legajo_persona->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$estado_actual_legajo_persona_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$estado_actual_legajo_persona_grid->StartRec = 1;
$estado_actual_legajo_persona_grid->StopRec = $estado_actual_legajo_persona_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($estado_actual_legajo_persona_grid->FormKeyCountName) && ($estado_actual_legajo_persona->CurrentAction == "gridadd" || $estado_actual_legajo_persona->CurrentAction == "gridedit" || $estado_actual_legajo_persona->CurrentAction == "F")) {
		$estado_actual_legajo_persona_grid->KeyCount = $objForm->GetValue($estado_actual_legajo_persona_grid->FormKeyCountName);
		$estado_actual_legajo_persona_grid->StopRec = $estado_actual_legajo_persona_grid->StartRec + $estado_actual_legajo_persona_grid->KeyCount - 1;
	}
}
$estado_actual_legajo_persona_grid->RecCnt = $estado_actual_legajo_persona_grid->StartRec - 1;
if ($estado_actual_legajo_persona_grid->Recordset && !$estado_actual_legajo_persona_grid->Recordset->EOF) {
	$estado_actual_legajo_persona_grid->Recordset->MoveFirst();
	$bSelectLimit = $estado_actual_legajo_persona_grid->UseSelectLimit;
	if (!$bSelectLimit && $estado_actual_legajo_persona_grid->StartRec > 1)
		$estado_actual_legajo_persona_grid->Recordset->Move($estado_actual_legajo_persona_grid->StartRec - 1);
} elseif (!$estado_actual_legajo_persona->AllowAddDeleteRow && $estado_actual_legajo_persona_grid->StopRec == 0) {
	$estado_actual_legajo_persona_grid->StopRec = $estado_actual_legajo_persona->GridAddRowCount;
}

// Initialize aggregate
$estado_actual_legajo_persona->RowType = EW_ROWTYPE_AGGREGATEINIT;
$estado_actual_legajo_persona->ResetAttrs();
$estado_actual_legajo_persona_grid->RenderRow();
if ($estado_actual_legajo_persona->CurrentAction == "gridadd")
	$estado_actual_legajo_persona_grid->RowIndex = 0;
if ($estado_actual_legajo_persona->CurrentAction == "gridedit")
	$estado_actual_legajo_persona_grid->RowIndex = 0;
while ($estado_actual_legajo_persona_grid->RecCnt < $estado_actual_legajo_persona_grid->StopRec) {
	$estado_actual_legajo_persona_grid->RecCnt++;
	if (intval($estado_actual_legajo_persona_grid->RecCnt) >= intval($estado_actual_legajo_persona_grid->StartRec)) {
		$estado_actual_legajo_persona_grid->RowCnt++;
		if ($estado_actual_legajo_persona->CurrentAction == "gridadd" || $estado_actual_legajo_persona->CurrentAction == "gridedit" || $estado_actual_legajo_persona->CurrentAction == "F") {
			$estado_actual_legajo_persona_grid->RowIndex++;
			$objForm->Index = $estado_actual_legajo_persona_grid->RowIndex;
			if ($objForm->HasValue($estado_actual_legajo_persona_grid->FormActionName))
				$estado_actual_legajo_persona_grid->RowAction = strval($objForm->GetValue($estado_actual_legajo_persona_grid->FormActionName));
			elseif ($estado_actual_legajo_persona->CurrentAction == "gridadd")
				$estado_actual_legajo_persona_grid->RowAction = "insert";
			else
				$estado_actual_legajo_persona_grid->RowAction = "";
		}

		// Set up key count
		$estado_actual_legajo_persona_grid->KeyCount = $estado_actual_legajo_persona_grid->RowIndex;

		// Init row class and style
		$estado_actual_legajo_persona->ResetAttrs();
		$estado_actual_legajo_persona->CssClass = "";
		if ($estado_actual_legajo_persona->CurrentAction == "gridadd") {
			if ($estado_actual_legajo_persona->CurrentMode == "copy") {
				$estado_actual_legajo_persona_grid->LoadRowValues($estado_actual_legajo_persona_grid->Recordset); // Load row values
				$estado_actual_legajo_persona_grid->SetRecordKey($estado_actual_legajo_persona_grid->RowOldKey, $estado_actual_legajo_persona_grid->Recordset); // Set old record key
			} else {
				$estado_actual_legajo_persona_grid->LoadDefaultValues(); // Load default values
				$estado_actual_legajo_persona_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$estado_actual_legajo_persona_grid->LoadRowValues($estado_actual_legajo_persona_grid->Recordset); // Load row values
		}
		$estado_actual_legajo_persona->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($estado_actual_legajo_persona->CurrentAction == "gridadd") // Grid add
			$estado_actual_legajo_persona->RowType = EW_ROWTYPE_ADD; // Render add
		if ($estado_actual_legajo_persona->CurrentAction == "gridadd" && $estado_actual_legajo_persona->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$estado_actual_legajo_persona_grid->RestoreCurrentRowFormValues($estado_actual_legajo_persona_grid->RowIndex); // Restore form values
		if ($estado_actual_legajo_persona->CurrentAction == "gridedit") { // Grid edit
			if ($estado_actual_legajo_persona->EventCancelled) {
				$estado_actual_legajo_persona_grid->RestoreCurrentRowFormValues($estado_actual_legajo_persona_grid->RowIndex); // Restore form values
			}
			if ($estado_actual_legajo_persona_grid->RowAction == "insert")
				$estado_actual_legajo_persona->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$estado_actual_legajo_persona->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($estado_actual_legajo_persona->CurrentAction == "gridedit" && ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT || $estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) && $estado_actual_legajo_persona->EventCancelled) // Update failed
			$estado_actual_legajo_persona_grid->RestoreCurrentRowFormValues($estado_actual_legajo_persona_grid->RowIndex); // Restore form values
		if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) // Edit row
			$estado_actual_legajo_persona_grid->EditRowCnt++;
		if ($estado_actual_legajo_persona->CurrentAction == "F") // Confirm row
			$estado_actual_legajo_persona_grid->RestoreCurrentRowFormValues($estado_actual_legajo_persona_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$estado_actual_legajo_persona->RowAttrs = array_merge($estado_actual_legajo_persona->RowAttrs, array('data-rowindex'=>$estado_actual_legajo_persona_grid->RowCnt, 'id'=>'r' . $estado_actual_legajo_persona_grid->RowCnt . '_estado_actual_legajo_persona', 'data-rowtype'=>$estado_actual_legajo_persona->RowType));

		// Render row
		$estado_actual_legajo_persona_grid->RenderRow();

		// Render list options
		$estado_actual_legajo_persona_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($estado_actual_legajo_persona_grid->RowAction <> "delete" && $estado_actual_legajo_persona_grid->RowAction <> "insertdelete" && !($estado_actual_legajo_persona_grid->RowAction == "insert" && $estado_actual_legajo_persona->CurrentAction == "F" && $estado_actual_legajo_persona_grid->EmptyRow())) {
?>
	<tr<?php echo $estado_actual_legajo_persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$estado_actual_legajo_persona_grid->ListOptions->Render("body", "left", $estado_actual_legajo_persona_grid->RowCnt);
?>
	<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
		<td data-name="Matricula"<?php echo $estado_actual_legajo_persona->Matricula->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Matricula" class="form-group estado_actual_legajo_persona_Matricula">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="{value}"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Matricula->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Matricula") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Matricula" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Matricula->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Matricula" class="form-group estado_actual_legajo_persona_Matricula">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="{value}"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Matricula->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Matricula") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Matricula" class="estado_actual_legajo_persona_Matricula">
<span<?php echo $estado_actual_legajo_persona->Matricula->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Matricula->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Matricula" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Matricula->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Matricula" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Matricula->OldValue) ?>">
<?php } ?>
<a id="<?php echo $estado_actual_legajo_persona_grid->PageObjName . "_row_" . $estado_actual_legajo_persona_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Dni" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Dni->CurrentValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Dni" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Dni->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT || $estado_actual_legajo_persona->CurrentMode == "edit") { ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Dni" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Dni->CurrentValue) ?>">
<?php } ?>
	<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
		<td data-name="Certificado_Pase"<?php echo $estado_actual_legajo_persona->Certificado_Pase->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Pase" class="form-group estado_actual_legajo_persona_Certificado_Pase">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Pase") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Pase->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Pase" class="form-group estado_actual_legajo_persona_Certificado_Pase">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Pase") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Pase" class="estado_actual_legajo_persona_Certificado_Pase">
<span<?php echo $estado_actual_legajo_persona->Certificado_Pase->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Pase->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Pase->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
		<td data-name="Tiene_DNI"<?php echo $estado_actual_legajo_persona->Tiene_DNI->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Tiene_DNI" class="form-group estado_actual_legajo_persona_Tiene_DNI">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="{value}"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Tiene_DNI") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Tiene_DNI->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Tiene_DNI" class="form-group estado_actual_legajo_persona_Tiene_DNI">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="{value}"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Tiene_DNI") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Tiene_DNI" class="estado_actual_legajo_persona_Tiene_DNI">
<span<?php echo $estado_actual_legajo_persona->Tiene_DNI->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Tiene_DNI->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Tiene_DNI->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
		<td data-name="Certificado_Medico"<?php echo $estado_actual_legajo_persona->Certificado_Medico->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Medico" class="form-group estado_actual_legajo_persona_Certificado_Medico">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Medico") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Medico->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Medico" class="form-group estado_actual_legajo_persona_Certificado_Medico">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Medico") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Certificado_Medico" class="estado_actual_legajo_persona_Certificado_Medico">
<span<?php echo $estado_actual_legajo_persona->Certificado_Medico->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Medico->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Medico->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
		<td data-name="Posee_Autorizacion"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Posee_Autorizacion" class="form-group estado_actual_legajo_persona_Posee_Autorizacion">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="{value}"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Posee_Autorizacion") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Posee_Autorizacion->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Posee_Autorizacion" class="form-group estado_actual_legajo_persona_Posee_Autorizacion">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="{value}"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Posee_Autorizacion") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Posee_Autorizacion" class="estado_actual_legajo_persona_Posee_Autorizacion">
<span<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Posee_Autorizacion->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Posee_Autorizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
		<td data-name="Cooperadora"<?php echo $estado_actual_legajo_persona->Cooperadora->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Cooperadora" class="form-group estado_actual_legajo_persona_Cooperadora">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="{value}"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Cooperadora->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Cooperadora") ?>
</div></div>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Cooperadora->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Cooperadora" class="form-group estado_actual_legajo_persona_Cooperadora">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="{value}"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Cooperadora->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Cooperadora") ?>
</div></div>
</span>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Cooperadora" class="estado_actual_legajo_persona_Cooperadora">
<span<?php echo $estado_actual_legajo_persona->Cooperadora->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Cooperadora->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Cooperadora->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Cooperadora->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Fecha_Actualizacion" class="estado_actual_legajo_persona_Fecha_Actualizacion">
<span<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $estado_actual_legajo_persona->Usuario->CellAttributes() ?>>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_actual_legajo_persona_grid->RowCnt ?>_estado_actual_legajo_persona_Usuario" class="estado_actual_legajo_persona_Usuario">
<span<?php echo $estado_actual_legajo_persona->Usuario->ViewAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->FormValue) ?>">
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estado_actual_legajo_persona_grid->ListOptions->Render("body", "right", $estado_actual_legajo_persona_grid->RowCnt);
?>
	</tr>
<?php if ($estado_actual_legajo_persona->RowType == EW_ROWTYPE_ADD || $estado_actual_legajo_persona->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
festado_actual_legajo_personagrid.UpdateOpts(<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($estado_actual_legajo_persona->CurrentAction <> "gridadd" || $estado_actual_legajo_persona->CurrentMode == "copy")
		if (!$estado_actual_legajo_persona_grid->Recordset->EOF) $estado_actual_legajo_persona_grid->Recordset->MoveNext();
}
?>
<?php
	if ($estado_actual_legajo_persona->CurrentMode == "add" || $estado_actual_legajo_persona->CurrentMode == "copy" || $estado_actual_legajo_persona->CurrentMode == "edit") {
		$estado_actual_legajo_persona_grid->RowIndex = '$rowindex$';
		$estado_actual_legajo_persona_grid->LoadDefaultValues();

		// Set row properties
		$estado_actual_legajo_persona->ResetAttrs();
		$estado_actual_legajo_persona->RowAttrs = array_merge($estado_actual_legajo_persona->RowAttrs, array('data-rowindex'=>$estado_actual_legajo_persona_grid->RowIndex, 'id'=>'r0_estado_actual_legajo_persona', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($estado_actual_legajo_persona->RowAttrs["class"], "ewTemplate");
		$estado_actual_legajo_persona->RowType = EW_ROWTYPE_ADD;

		// Render row
		$estado_actual_legajo_persona_grid->RenderRow();

		// Render list options
		$estado_actual_legajo_persona_grid->RenderListOptions();
		$estado_actual_legajo_persona_grid->StartRowCnt = 0;
?>
	<tr<?php echo $estado_actual_legajo_persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$estado_actual_legajo_persona_grid->ListOptions->Render("body", "left", $estado_actual_legajo_persona_grid->RowIndex);
?>
	<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
		<td data-name="Matricula">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Matricula" class="form-group estado_actual_legajo_persona_Matricula">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="{value}"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Matricula->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Matricula") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Matricula" class="form-group estado_actual_legajo_persona_Matricula">
<span<?php echo $estado_actual_legajo_persona->Matricula->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Matricula->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Matricula" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Matricula->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Matricula" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Matricula" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Matricula->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
		<td data-name="Certificado_Pase">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Certificado_Pase" class="form-group estado_actual_legajo_persona_Certificado_Pase">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Pase") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Certificado_Pase" class="form-group estado_actual_legajo_persona_Certificado_Pase">
<span<?php echo $estado_actual_legajo_persona->Certificado_Pase->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Certificado_Pase->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Pase->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Pase" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Pase->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
		<td data-name="Tiene_DNI">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Tiene_DNI" class="form-group estado_actual_legajo_persona_Tiene_DNI">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="{value}"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Tiene_DNI") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Tiene_DNI" class="form-group estado_actual_legajo_persona_Tiene_DNI">
<span<?php echo $estado_actual_legajo_persona->Tiene_DNI->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Tiene_DNI->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Tiene_DNI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Tiene_DNI" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Tiene_DNI->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
		<td data-name="Certificado_Medico">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Certificado_Medico" class="form-group estado_actual_legajo_persona_Certificado_Medico">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Certificado_Medico") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Certificado_Medico" class="form-group estado_actual_legajo_persona_Certificado_Medico">
<span<?php echo $estado_actual_legajo_persona->Certificado_Medico->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Certificado_Medico->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Medico->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Certificado_Medico" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Certificado_Medico->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
		<td data-name="Posee_Autorizacion">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Posee_Autorizacion" class="form-group estado_actual_legajo_persona_Posee_Autorizacion">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="{value}"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Posee_Autorizacion") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Posee_Autorizacion" class="form-group estado_actual_legajo_persona_Posee_Autorizacion">
<span<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Posee_Autorizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Posee_Autorizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Posee_Autorizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
		<td data-name="Cooperadora">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Cooperadora" class="form-group estado_actual_legajo_persona_Cooperadora">
<div id="tp_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="{value}"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Cooperadora->RadioButtonListHtml(FALSE, "x{$estado_actual_legajo_persona_grid->RowIndex}_Cooperadora") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Cooperadora" class="form-group estado_actual_legajo_persona_Cooperadora">
<span<?php echo $estado_actual_legajo_persona->Cooperadora->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Cooperadora->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Cooperadora->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Cooperadora" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Cooperadora->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Fecha_Actualizacion" class="form-group estado_actual_legajo_persona_Fecha_Actualizacion">
<span<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_actual_legajo_persona->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($estado_actual_legajo_persona->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_estado_actual_legajo_persona_Usuario" class="form-group estado_actual_legajo_persona_Usuario">
<span<?php echo $estado_actual_legajo_persona->Usuario->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_actual_legajo_persona->Usuario->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" id="x<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" id="o<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estado_actual_legajo_persona_grid->ListOptions->Render("body", "right", $estado_actual_legajo_persona_grid->RowCnt);
?>
<script type="text/javascript">
festado_actual_legajo_personagrid.UpdateOpts(<?php echo $estado_actual_legajo_persona_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($estado_actual_legajo_persona->CurrentMode == "add" || $estado_actual_legajo_persona->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $estado_actual_legajo_persona_grid->FormKeyCountName ?>" id="<?php echo $estado_actual_legajo_persona_grid->FormKeyCountName ?>" value="<?php echo $estado_actual_legajo_persona_grid->KeyCount ?>">
<?php echo $estado_actual_legajo_persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($estado_actual_legajo_persona->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $estado_actual_legajo_persona_grid->FormKeyCountName ?>" id="<?php echo $estado_actual_legajo_persona_grid->FormKeyCountName ?>" value="<?php echo $estado_actual_legajo_persona_grid->KeyCount ?>">
<?php echo $estado_actual_legajo_persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($estado_actual_legajo_persona->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="festado_actual_legajo_personagrid">
</div>
<?php

// Close recordset
if ($estado_actual_legajo_persona_grid->Recordset)
	$estado_actual_legajo_persona_grid->Recordset->Close();
?>
<?php if ($estado_actual_legajo_persona_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($estado_actual_legajo_persona_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona_grid->TotalRecs == 0 && $estado_actual_legajo_persona->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($estado_actual_legajo_persona_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Export == "") { ?>
<script type="text/javascript">
festado_actual_legajo_personagrid.Init();
</script>
<?php } ?>
<?php
$estado_actual_legajo_persona_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$estado_actual_legajo_persona_grid->Page_Terminate();
?>
