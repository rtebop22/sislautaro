<?php

// Create page object
if (!isset($personas_grid)) $personas_grid = new cpersonas_grid();

// Page init
$personas_grid->Page_Init();

// Page main
$personas_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personas_grid->Page_Render();
?>
<?php if ($personas->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpersonasgrid = new ew_Form("fpersonasgrid", "grid");
fpersonasgrid.FormKeyCountName = '<?php echo $personas_grid->FormKeyCountName ?>';

// Validate form
fpersonasgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellidos_Nombres");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Apellidos_Nombres->FldCaption(), $personas->Apellidos_Nombres->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Dni->FldCaption(), $personas->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Estado->FldCaption(), $personas->Id_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Curso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Curso->FldCaption(), $personas->Id_Curso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Division");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Division->FldCaption(), $personas->Id_Division->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Turno->FldCaption(), $personas->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Cargo->FldCaption(), $personas->Id_Cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Dni_Tutor->FldCaption(), $personas->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->NroSerie->FldCaption(), $personas->NroSerie->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpersonasgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Apellidos_Nombres", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Dni", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Curso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Division", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Cargo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Dni_Tutor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersonasgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonasgrid.ValidateRequired = true;
<?php } else { ?>
fpersonasgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonasgrid.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_persona"};
fpersonasgrid.Lists["x_Id_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
fpersonasgrid.Lists["x_Id_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
fpersonasgrid.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
fpersonasgrid.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_persona"};
fpersonasgrid.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fpersonasgrid.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
</script>
<?php } ?>
<?php
if ($personas->CurrentAction == "gridadd") {
	if ($personas->CurrentMode == "copy") {
		$bSelectLimit = $personas_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$personas_grid->TotalRecs = $personas->SelectRecordCount();
			$personas_grid->Recordset = $personas_grid->LoadRecordset($personas_grid->StartRec-1, $personas_grid->DisplayRecs);
		} else {
			if ($personas_grid->Recordset = $personas_grid->LoadRecordset())
				$personas_grid->TotalRecs = $personas_grid->Recordset->RecordCount();
		}
		$personas_grid->StartRec = 1;
		$personas_grid->DisplayRecs = $personas_grid->TotalRecs;
	} else {
		$personas->CurrentFilter = "0=1";
		$personas_grid->StartRec = 1;
		$personas_grid->DisplayRecs = $personas->GridAddRowCount;
	}
	$personas_grid->TotalRecs = $personas_grid->DisplayRecs;
	$personas_grid->StopRec = $personas_grid->DisplayRecs;
} else {
	$bSelectLimit = $personas_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($personas_grid->TotalRecs <= 0)
			$personas_grid->TotalRecs = $personas->SelectRecordCount();
	} else {
		if (!$personas_grid->Recordset && ($personas_grid->Recordset = $personas_grid->LoadRecordset()))
			$personas_grid->TotalRecs = $personas_grid->Recordset->RecordCount();
	}
	$personas_grid->StartRec = 1;
	$personas_grid->DisplayRecs = $personas_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$personas_grid->Recordset = $personas_grid->LoadRecordset($personas_grid->StartRec-1, $personas_grid->DisplayRecs);

	// Set no record found message
	if ($personas->CurrentAction == "" && $personas_grid->TotalRecs == 0) {
		if ($personas_grid->SearchWhere == "0=101")
			$personas_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$personas_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$personas_grid->RenderOtherOptions();
?>
<?php $personas_grid->ShowPageHeader(); ?>
<?php
$personas_grid->ShowMessage();
?>
<?php if ($personas_grid->TotalRecs > 0 || $personas->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid personas">
<div id="fpersonasgrid" class="ewForm form-inline">
<div id="gmp_personas" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_personasgrid" class="table ewTable">
<?php echo $personas->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$personas_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$personas_grid->RenderListOptions();

// Render list options (header, left)
$personas_grid->ListOptions->Render("header", "left");
?>
<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<?php if ($personas->SortUrl($personas->Apellidos_Nombres) == "") { ?>
		<th data-name="Apellidos_Nombres"><div id="elh_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres"><div class="ewTableHeaderCaption"><?php echo $personas->Apellidos_Nombres->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellidos_Nombres"><div><div id="elh_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Apellidos_Nombres->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Apellidos_Nombres->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Apellidos_Nombres->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Dni->Visible) { // Dni ?>
	<?php if ($personas->SortUrl($personas->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_personas_Dni" class="personas_Dni"><div class="ewTableHeaderCaption"><?php echo $personas->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div><div id="elh_personas_Dni" class="personas_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Dni->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Cuil->Visible) { // Cuil ?>
	<?php if ($personas->SortUrl($personas->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_personas_Cuil" class="personas_Cuil"><div class="ewTableHeaderCaption"><?php echo $personas->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div><div id="elh_personas_Cuil" class="personas_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Cuil->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($personas->SortUrl($personas->Id_Estado) == "") { ?>
		<th data-name="Id_Estado"><div id="elh_personas_Id_Estado" class="personas_Id_Estado"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado"><div><div id="elh_personas_Id_Estado" class="personas_Id_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
	<?php if ($personas->SortUrl($personas->Id_Curso) == "") { ?>
		<th data-name="Id_Curso"><div id="elh_personas_Id_Curso" class="personas_Id_Curso"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Curso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Curso"><div><div id="elh_personas_Id_Curso" class="personas_Id_Curso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Curso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Curso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Curso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
	<?php if ($personas->SortUrl($personas->Id_Division) == "") { ?>
		<th data-name="Id_Division"><div id="elh_personas_Id_Division" class="personas_Id_Division"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Division->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Division"><div><div id="elh_personas_Id_Division" class="personas_Id_Division">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Division->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Division->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Division->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($personas->SortUrl($personas->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_personas_Id_Turno" class="personas_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div><div id="elh_personas_Id_Turno" class="personas_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
	<?php if ($personas->SortUrl($personas->Id_Cargo) == "") { ?>
		<th data-name="Id_Cargo"><div id="elh_personas_Id_Cargo" class="personas_Id_Cargo"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Cargo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Cargo"><div><div id="elh_personas_Id_Cargo" class="personas_Id_Cargo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Cargo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Cargo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Cargo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<?php if ($personas->SortUrl($personas->Dni_Tutor) == "") { ?>
		<th data-name="Dni_Tutor"><div id="elh_personas_Dni_Tutor" class="personas_Dni_Tutor"><div class="ewTableHeaderCaption"><?php echo $personas->Dni_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni_Tutor"><div><div id="elh_personas_Dni_Tutor" class="personas_Dni_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Dni_Tutor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Dni_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Dni_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
	<?php if ($personas->SortUrl($personas->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_personas_NroSerie" class="personas_NroSerie"><div class="ewTableHeaderCaption"><?php echo $personas->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div><div id="elh_personas_NroSerie" class="personas_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->NroSerie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$personas_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$personas_grid->StartRec = 1;
$personas_grid->StopRec = $personas_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($personas_grid->FormKeyCountName) && ($personas->CurrentAction == "gridadd" || $personas->CurrentAction == "gridedit" || $personas->CurrentAction == "F")) {
		$personas_grid->KeyCount = $objForm->GetValue($personas_grid->FormKeyCountName);
		$personas_grid->StopRec = $personas_grid->StartRec + $personas_grid->KeyCount - 1;
	}
}
$personas_grid->RecCnt = $personas_grid->StartRec - 1;
if ($personas_grid->Recordset && !$personas_grid->Recordset->EOF) {
	$personas_grid->Recordset->MoveFirst();
	$bSelectLimit = $personas_grid->UseSelectLimit;
	if (!$bSelectLimit && $personas_grid->StartRec > 1)
		$personas_grid->Recordset->Move($personas_grid->StartRec - 1);
} elseif (!$personas->AllowAddDeleteRow && $personas_grid->StopRec == 0) {
	$personas_grid->StopRec = $personas->GridAddRowCount;
}

// Initialize aggregate
$personas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$personas->ResetAttrs();
$personas_grid->RenderRow();
if ($personas->CurrentAction == "gridadd")
	$personas_grid->RowIndex = 0;
if ($personas->CurrentAction == "gridedit")
	$personas_grid->RowIndex = 0;
while ($personas_grid->RecCnt < $personas_grid->StopRec) {
	$personas_grid->RecCnt++;
	if (intval($personas_grid->RecCnt) >= intval($personas_grid->StartRec)) {
		$personas_grid->RowCnt++;
		if ($personas->CurrentAction == "gridadd" || $personas->CurrentAction == "gridedit" || $personas->CurrentAction == "F") {
			$personas_grid->RowIndex++;
			$objForm->Index = $personas_grid->RowIndex;
			if ($objForm->HasValue($personas_grid->FormActionName))
				$personas_grid->RowAction = strval($objForm->GetValue($personas_grid->FormActionName));
			elseif ($personas->CurrentAction == "gridadd")
				$personas_grid->RowAction = "insert";
			else
				$personas_grid->RowAction = "";
		}

		// Set up key count
		$personas_grid->KeyCount = $personas_grid->RowIndex;

		// Init row class and style
		$personas->ResetAttrs();
		$personas->CssClass = "";
		if ($personas->CurrentAction == "gridadd") {
			if ($personas->CurrentMode == "copy") {
				$personas_grid->LoadRowValues($personas_grid->Recordset); // Load row values
				$personas_grid->SetRecordKey($personas_grid->RowOldKey, $personas_grid->Recordset); // Set old record key
			} else {
				$personas_grid->LoadDefaultValues(); // Load default values
				$personas_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$personas_grid->LoadRowValues($personas_grid->Recordset); // Load row values
		}
		$personas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($personas->CurrentAction == "gridadd") // Grid add
			$personas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($personas->CurrentAction == "gridadd" && $personas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$personas_grid->RestoreCurrentRowFormValues($personas_grid->RowIndex); // Restore form values
		if ($personas->CurrentAction == "gridedit") { // Grid edit
			if ($personas->EventCancelled) {
				$personas_grid->RestoreCurrentRowFormValues($personas_grid->RowIndex); // Restore form values
			}
			if ($personas_grid->RowAction == "insert")
				$personas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$personas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($personas->CurrentAction == "gridedit" && ($personas->RowType == EW_ROWTYPE_EDIT || $personas->RowType == EW_ROWTYPE_ADD) && $personas->EventCancelled) // Update failed
			$personas_grid->RestoreCurrentRowFormValues($personas_grid->RowIndex); // Restore form values
		if ($personas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$personas_grid->EditRowCnt++;
		if ($personas->CurrentAction == "F") // Confirm row
			$personas_grid->RestoreCurrentRowFormValues($personas_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$personas->RowAttrs = array_merge($personas->RowAttrs, array('data-rowindex'=>$personas_grid->RowCnt, 'id'=>'r' . $personas_grid->RowCnt . '_personas', 'data-rowtype'=>$personas->RowType));

		// Render row
		$personas_grid->RenderRow();

		// Render list options
		$personas_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($personas_grid->RowAction <> "delete" && $personas_grid->RowAction <> "insertdelete" && !($personas_grid->RowAction == "insert" && $personas->CurrentAction == "F" && $personas_grid->EmptyRow())) {
?>
	<tr<?php echo $personas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personas_grid->ListOptions->Render("body", "left", $personas_grid->RowCnt);
?>
	<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres"<?php echo $personas->Apellidos_Nombres->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres">
<span<?php echo $personas->Apellidos_Nombres->ViewAttributes() ?>>
<?php echo $personas->Apellidos_Nombres->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personas_grid->PageObjName . "_row_" . $personas_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personas->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $personas->Dni->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni" class="form-group personas_Dni">
<input type="text" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_grid->RowIndex ?>_Dni" id="x<?php echo $personas_grid->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->Dni->getPlaceHolder()) ?>" value="<?php echo $personas->Dni->EditValue ?>"<?php echo $personas->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_grid->RowIndex ?>_Dni" id="o<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni" class="form-group personas_Dni">
<span<?php echo $personas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Dni->EditValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_grid->RowIndex ?>_Dni" id="x<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->CurrentValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni" class="personas_Dni">
<span<?php echo $personas->Dni->ViewAttributes() ?>>
<?php echo $personas->Dni->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_grid->RowIndex ?>_Dni" id="x<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_grid->RowIndex ?>_Dni" id="o<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $personas->Cuil->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Cuil" class="form-group personas_Cuil">
<input type="text" data-table="personas" data-field="x_Cuil" name="x<?php echo $personas_grid->RowIndex ?>_Cuil" id="x<?php echo $personas_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($personas->Cuil->getPlaceHolder()) ?>" value="<?php echo $personas->Cuil->EditValue ?>"<?php echo $personas->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Cuil" name="o<?php echo $personas_grid->RowIndex ?>_Cuil" id="o<?php echo $personas_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($personas->Cuil->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Cuil" class="form-group personas_Cuil">
<input type="text" data-table="personas" data-field="x_Cuil" name="x<?php echo $personas_grid->RowIndex ?>_Cuil" id="x<?php echo $personas_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($personas->Cuil->getPlaceHolder()) ?>" value="<?php echo $personas->Cuil->EditValue ?>"<?php echo $personas->Cuil->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Cuil" class="personas_Cuil">
<span<?php echo $personas->Cuil->ViewAttributes() ?>>
<?php echo $personas->Cuil->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Cuil" name="x<?php echo $personas_grid->RowIndex ?>_Cuil" id="x<?php echo $personas_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($personas->Cuil->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Cuil" name="o<?php echo $personas_grid->RowIndex ?>_Cuil" id="o<?php echo $personas_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($personas->Cuil->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado"<?php echo $personas->Id_Estado->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" name="x<?php echo $personas_grid->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" name="x<?php echo $personas_grid->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Estado" class="personas_Id_Estado">
<span<?php echo $personas->Id_Estado->ViewAttributes() ?>>
<?php echo $personas->Id_Estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
		<td data-name="Id_Curso"<?php echo $personas->Id_Curso->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" name="x<?php echo $personas_grid->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" name="x<?php echo $personas_grid->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Curso" class="personas_Id_Curso">
<span<?php echo $personas->Id_Curso->ViewAttributes() ?>>
<?php echo $personas->Id_Curso->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
		<td data-name="Id_Division"<?php echo $personas->Id_Division->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Division" name="x<?php echo $personas_grid->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_grid->RowIndex ?>_Id_Division" id="o<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Division" name="x<?php echo $personas_grid->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Division" class="personas_Id_Division">
<span<?php echo $personas->Id_Division->ViewAttributes() ?>>
<?php echo $personas->Id_Division->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="x<?php echo $personas_grid->RowIndex ?>_Id_Division" id="x<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_grid->RowIndex ?>_Id_Division" id="o<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $personas->Id_Turno->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" name="x<?php echo $personas_grid->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" name="x<?php echo $personas_grid->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Turno" class="personas_Id_Turno">
<span<?php echo $personas->Id_Turno->ViewAttributes() ?>>
<?php echo $personas->Id_Turno->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo"<?php echo $personas->Id_Cargo->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Id_Cargo" class="personas_Id_Cargo">
<span<?php echo $personas->Id_Cargo->ViewAttributes() ?>>
<?php echo $personas->Id_Cargo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor"<?php echo $personas->Dni_Tutor->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_Dni_Tutor" class="personas_Dni_Tutor">
<span<?php echo $personas->Dni_Tutor->ViewAttributes() ?>>
<?php echo $personas->Dni_Tutor->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $personas->NroSerie->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($personas->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_NroSerie"><?php echo (strval($personas->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->CurrentValue ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_grid->RowIndex ?>_NroSerie" id="o<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($personas->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_NroSerie"><?php echo (strval($personas->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->CurrentValue ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_grid->RowCnt ?>_personas_NroSerie" class="personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<?php echo $personas->NroSerie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->FormValue) ?>">
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_grid->RowIndex ?>_NroSerie" id="o<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personas_grid->ListOptions->Render("body", "right", $personas_grid->RowCnt);
?>
	</tr>
<?php if ($personas->RowType == EW_ROWTYPE_ADD || $personas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersonasgrid.UpdateOpts(<?php echo $personas_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($personas->CurrentAction <> "gridadd" || $personas->CurrentMode == "copy")
		if (!$personas_grid->Recordset->EOF) $personas_grid->Recordset->MoveNext();
}
?>
<?php
	if ($personas->CurrentMode == "add" || $personas->CurrentMode == "copy" || $personas->CurrentMode == "edit") {
		$personas_grid->RowIndex = '$rowindex$';
		$personas_grid->LoadDefaultValues();

		// Set row properties
		$personas->ResetAttrs();
		$personas->RowAttrs = array_merge($personas->RowAttrs, array('data-rowindex'=>$personas_grid->RowIndex, 'id'=>'r0_personas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($personas->RowAttrs["class"], "ewTemplate");
		$personas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$personas_grid->RenderRow();

		// Render list options
		$personas_grid->RenderListOptions();
		$personas_grid->StartRowCnt = 0;
?>
	<tr<?php echo $personas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personas_grid->ListOptions->Render("body", "left", $personas_grid->RowIndex);
?>
	<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<span<?php echo $personas->Apellidos_Nombres->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Apellidos_Nombres->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Dni" class="form-group personas_Dni">
<input type="text" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_grid->RowIndex ?>_Dni" id="x<?php echo $personas_grid->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->Dni->getPlaceHolder()) ?>" value="<?php echo $personas->Dni->EditValue ?>"<?php echo $personas->Dni->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Dni" class="form-group personas_Dni">
<span<?php echo $personas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Dni->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_grid->RowIndex ?>_Dni" id="x<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_grid->RowIndex ?>_Dni" id="o<?php echo $personas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Cuil" class="form-group personas_Cuil">
<input type="text" data-table="personas" data-field="x_Cuil" name="x<?php echo $personas_grid->RowIndex ?>_Cuil" id="x<?php echo $personas_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($personas->Cuil->getPlaceHolder()) ?>" value="<?php echo $personas->Cuil->EditValue ?>"<?php echo $personas->Cuil->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Cuil" class="form-group personas_Cuil">
<span<?php echo $personas->Cuil->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Cuil->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Cuil" name="x<?php echo $personas_grid->RowIndex ?>_Cuil" id="x<?php echo $personas_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($personas->Cuil->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Cuil" name="o<?php echo $personas_grid->RowIndex ?>_Cuil" id="o<?php echo $personas_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($personas->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" name="x<?php echo $personas_grid->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Id_Estado" class="form-group personas_Id_Estado">
<span<?php echo $personas->Id_Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Id_Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="x<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" id="o<?php echo $personas_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
		<td data-name="Id_Curso">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" name="x<?php echo $personas_grid->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Id_Curso" class="form-group personas_Id_Curso">
<span<?php echo $personas->Id_Curso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Id_Curso->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="x<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" id="o<?php echo $personas_grid->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
		<td data-name="Id_Division">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Division" name="x<?php echo $personas_grid->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Id_Division" class="form-group personas_Id_Division">
<span<?php echo $personas->Id_Division->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Id_Division->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="x<?php echo $personas_grid->RowIndex ?>_Id_Division" id="x<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_grid->RowIndex ?>_Id_Division" id="o<?php echo $personas_grid->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" name="x<?php echo $personas_grid->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Id_Turno" class="form-group personas_Id_Turno">
<span<?php echo $personas->Id_Turno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Id_Turno->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="x<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" id="o<?php echo $personas_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<span<?php echo $personas->Id_Cargo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Id_Cargo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="x<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<?php if ($personas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span<?php echo $personas->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($personas->CurrentAction <> "F") { ?>
<?php if ($personas->NroSerie->getSessionValue() <> "") { ?>
<span id="el$rowindex$_personas_NroSerie" class="form-group personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_personas_NroSerie" class="form-group personas_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_grid->RowIndex ?>_NroSerie"><?php echo (strval($personas->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->CurrentValue ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_personas_NroSerie" class="form-group personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="x<?php echo $personas_grid->RowIndex ?>_NroSerie" id="x<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_grid->RowIndex ?>_NroSerie" id="o<?php echo $personas_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personas_grid->ListOptions->Render("body", "right", $personas_grid->RowCnt);
?>
<script type="text/javascript">
fpersonasgrid.UpdateOpts(<?php echo $personas_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($personas->CurrentMode == "add" || $personas->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $personas_grid->FormKeyCountName ?>" id="<?php echo $personas_grid->FormKeyCountName ?>" value="<?php echo $personas_grid->KeyCount ?>">
<?php echo $personas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($personas->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $personas_grid->FormKeyCountName ?>" id="<?php echo $personas_grid->FormKeyCountName ?>" value="<?php echo $personas_grid->KeyCount ?>">
<?php echo $personas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($personas->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpersonasgrid">
</div>
<?php

// Close recordset
if ($personas_grid->Recordset)
	$personas_grid->Recordset->Close();
?>
<?php if ($personas_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($personas_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($personas_grid->TotalRecs == 0 && $personas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personas_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($personas->Export == "") { ?>
<script type="text/javascript">
fpersonasgrid.Init();
</script>
<?php } ?>
<?php
$personas_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$personas_grid->Page_Terminate();
?>
