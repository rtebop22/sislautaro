<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($piso_tecnologico_grid)) $piso_tecnologico_grid = new cpiso_tecnologico_grid();

// Page init
$piso_tecnologico_grid->Page_Init();

// Page main
$piso_tecnologico_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_grid->Page_Render();
?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpiso_tecnologicogrid = new ew_Form("fpiso_tecnologicogrid", "grid");
fpiso_tecnologicogrid.FormKeyCountName = '<?php echo $piso_tecnologico_grid->FormKeyCountName ?>';

// Validate form
fpiso_tecnologicogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Switch->FldCaption(), $piso_tecnologico->Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bocas_Switch");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Bocas_Switch->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Switch->FldCaption(), $piso_tecnologico->Estado_Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cantidad_Ap->FldCaption(), $piso_tecnologico->Cantidad_Ap->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap_Func");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap_Func->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Ups->FldCaption(), $piso_tecnologico->Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Ups->FldCaption(), $piso_tecnologico->Estado_Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cableado->FldCaption(), $piso_tecnologico->Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Cableado->FldCaption(), $piso_tecnologico->Estado_Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Estado_Cab");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Cab->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Func_Piso");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Func_Piso->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpiso_tecnologicogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Bocas_Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Ap", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Ap_Func", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Ups", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Ups", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cableado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Cableado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Porcent_Estado_Cab", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Porcent_Func_Piso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Plano_Escuela", false)) return false;
	return true;
}

// Form_CustomValidate event
fpiso_tecnologicogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicogrid.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicogrid.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicogrid.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicogrid.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicogrid.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicogrid.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicogrid.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicogrid.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicogrid.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicogrid.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
</script>
<?php } ?>
<?php
if ($piso_tecnologico->CurrentAction == "gridadd") {
	if ($piso_tecnologico->CurrentMode == "copy") {
		$bSelectLimit = $piso_tecnologico_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$piso_tecnologico_grid->TotalRecs = $piso_tecnologico->SelectRecordCount();
			$piso_tecnologico_grid->Recordset = $piso_tecnologico_grid->LoadRecordset($piso_tecnologico_grid->StartRec-1, $piso_tecnologico_grid->DisplayRecs);
		} else {
			if ($piso_tecnologico_grid->Recordset = $piso_tecnologico_grid->LoadRecordset())
				$piso_tecnologico_grid->TotalRecs = $piso_tecnologico_grid->Recordset->RecordCount();
		}
		$piso_tecnologico_grid->StartRec = 1;
		$piso_tecnologico_grid->DisplayRecs = $piso_tecnologico_grid->TotalRecs;
	} else {
		$piso_tecnologico->CurrentFilter = "0=1";
		$piso_tecnologico_grid->StartRec = 1;
		$piso_tecnologico_grid->DisplayRecs = $piso_tecnologico->GridAddRowCount;
	}
	$piso_tecnologico_grid->TotalRecs = $piso_tecnologico_grid->DisplayRecs;
	$piso_tecnologico_grid->StopRec = $piso_tecnologico_grid->DisplayRecs;
} else {
	$bSelectLimit = $piso_tecnologico_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($piso_tecnologico_grid->TotalRecs <= 0)
			$piso_tecnologico_grid->TotalRecs = $piso_tecnologico->SelectRecordCount();
	} else {
		if (!$piso_tecnologico_grid->Recordset && ($piso_tecnologico_grid->Recordset = $piso_tecnologico_grid->LoadRecordset()))
			$piso_tecnologico_grid->TotalRecs = $piso_tecnologico_grid->Recordset->RecordCount();
	}
	$piso_tecnologico_grid->StartRec = 1;
	$piso_tecnologico_grid->DisplayRecs = $piso_tecnologico_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$piso_tecnologico_grid->Recordset = $piso_tecnologico_grid->LoadRecordset($piso_tecnologico_grid->StartRec-1, $piso_tecnologico_grid->DisplayRecs);

	// Set no record found message
	if ($piso_tecnologico->CurrentAction == "" && $piso_tecnologico_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$piso_tecnologico_grid->setWarningMessage(ew_DeniedMsg());
		if ($piso_tecnologico_grid->SearchWhere == "0=101")
			$piso_tecnologico_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$piso_tecnologico_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$piso_tecnologico_grid->RenderOtherOptions();
?>
<?php $piso_tecnologico_grid->ShowPageHeader(); ?>
<?php
$piso_tecnologico_grid->ShowMessage();
?>
<?php if ($piso_tecnologico_grid->TotalRecs > 0 || $piso_tecnologico->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid piso_tecnologico">
<div id="fpiso_tecnologicogrid" class="ewForm form-inline">
<?php if ($piso_tecnologico_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($piso_tecnologico_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_piso_tecnologico" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_piso_tecnologicogrid" class="table ewTable">
<?php echo $piso_tecnologico->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$piso_tecnologico_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$piso_tecnologico_grid->RenderListOptions();

// Render list options (header, left)
$piso_tecnologico_grid->ListOptions->Render("header", "left");
?>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Switch) == "") { ?>
		<th data-name="Switch"><div id="elh_piso_tecnologico_Switch" class="piso_tecnologico_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Switch"><div><div id="elh_piso_tecnologico_Switch" class="piso_tecnologico_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Bocas_Switch) == "") { ?>
		<th data-name="Bocas_Switch"><div id="elh_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bocas_Switch"><div><div id="elh_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Bocas_Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Bocas_Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Switch) == "") { ?>
		<th data-name="Estado_Switch"><div id="elh_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Switch"><div><div id="elh_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap) == "") { ?>
		<th data-name="Cantidad_Ap"><div id="elh_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Ap"><div><div id="elh_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cantidad_Ap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cantidad_Ap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap_Func) == "") { ?>
		<th data-name="Cantidad_Ap_Func"><div id="elh_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Ap_Func"><div><div id="elh_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cantidad_Ap_Func->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cantidad_Ap_Func->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Ups) == "") { ?>
		<th data-name="Ups"><div id="elh_piso_tecnologico_Ups" class="piso_tecnologico_Ups"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Ups->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Ups"><div><div id="elh_piso_tecnologico_Ups" class="piso_tecnologico_Ups">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Ups->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Ups->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Ups->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Ups) == "") { ?>
		<th data-name="Estado_Ups"><div id="elh_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Ups"><div><div id="elh_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Ups->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Ups->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cableado) == "") { ?>
		<th data-name="Cableado"><div id="elh_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cableado"><div><div id="elh_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cableado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cableado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Cableado) == "") { ?>
		<th data-name="Estado_Cableado"><div id="elh_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Cableado"><div><div id="elh_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Cableado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Cableado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Estado_Cab) == "") { ?>
		<th data-name="Porcent_Estado_Cab"><div id="elh_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Porcent_Estado_Cab"><div><div id="elh_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Porcent_Estado_Cab->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Porcent_Estado_Cab->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Func_Piso) == "") { ?>
		<th data-name="Porcent_Func_Piso"><div id="elh_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Porcent_Func_Piso"><div><div id="elh_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Porcent_Func_Piso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Porcent_Func_Piso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Plano_Escuela) == "") { ?>
		<th data-name="Plano_Escuela"><div id="elh_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Plano_Escuela"><div><div id="elh_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Plano_Escuela->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Plano_Escuela->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$piso_tecnologico_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$piso_tecnologico_grid->StartRec = 1;
$piso_tecnologico_grid->StopRec = $piso_tecnologico_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($piso_tecnologico_grid->FormKeyCountName) && ($piso_tecnologico->CurrentAction == "gridadd" || $piso_tecnologico->CurrentAction == "gridedit" || $piso_tecnologico->CurrentAction == "F")) {
		$piso_tecnologico_grid->KeyCount = $objForm->GetValue($piso_tecnologico_grid->FormKeyCountName);
		$piso_tecnologico_grid->StopRec = $piso_tecnologico_grid->StartRec + $piso_tecnologico_grid->KeyCount - 1;
	}
}
$piso_tecnologico_grid->RecCnt = $piso_tecnologico_grid->StartRec - 1;
if ($piso_tecnologico_grid->Recordset && !$piso_tecnologico_grid->Recordset->EOF) {
	$piso_tecnologico_grid->Recordset->MoveFirst();
	$bSelectLimit = $piso_tecnologico_grid->UseSelectLimit;
	if (!$bSelectLimit && $piso_tecnologico_grid->StartRec > 1)
		$piso_tecnologico_grid->Recordset->Move($piso_tecnologico_grid->StartRec - 1);
} elseif (!$piso_tecnologico->AllowAddDeleteRow && $piso_tecnologico_grid->StopRec == 0) {
	$piso_tecnologico_grid->StopRec = $piso_tecnologico->GridAddRowCount;
}

// Initialize aggregate
$piso_tecnologico->RowType = EW_ROWTYPE_AGGREGATEINIT;
$piso_tecnologico->ResetAttrs();
$piso_tecnologico_grid->RenderRow();
if ($piso_tecnologico->CurrentAction == "gridadd")
	$piso_tecnologico_grid->RowIndex = 0;
if ($piso_tecnologico->CurrentAction == "gridedit")
	$piso_tecnologico_grid->RowIndex = 0;
while ($piso_tecnologico_grid->RecCnt < $piso_tecnologico_grid->StopRec) {
	$piso_tecnologico_grid->RecCnt++;
	if (intval($piso_tecnologico_grid->RecCnt) >= intval($piso_tecnologico_grid->StartRec)) {
		$piso_tecnologico_grid->RowCnt++;
		if ($piso_tecnologico->CurrentAction == "gridadd" || $piso_tecnologico->CurrentAction == "gridedit" || $piso_tecnologico->CurrentAction == "F") {
			$piso_tecnologico_grid->RowIndex++;
			$objForm->Index = $piso_tecnologico_grid->RowIndex;
			if ($objForm->HasValue($piso_tecnologico_grid->FormActionName))
				$piso_tecnologico_grid->RowAction = strval($objForm->GetValue($piso_tecnologico_grid->FormActionName));
			elseif ($piso_tecnologico->CurrentAction == "gridadd")
				$piso_tecnologico_grid->RowAction = "insert";
			else
				$piso_tecnologico_grid->RowAction = "";
		}

		// Set up key count
		$piso_tecnologico_grid->KeyCount = $piso_tecnologico_grid->RowIndex;

		// Init row class and style
		$piso_tecnologico->ResetAttrs();
		$piso_tecnologico->CssClass = "";
		if ($piso_tecnologico->CurrentAction == "gridadd") {
			if ($piso_tecnologico->CurrentMode == "copy") {
				$piso_tecnologico_grid->LoadRowValues($piso_tecnologico_grid->Recordset); // Load row values
				$piso_tecnologico_grid->SetRecordKey($piso_tecnologico_grid->RowOldKey, $piso_tecnologico_grid->Recordset); // Set old record key
			} else {
				$piso_tecnologico_grid->LoadDefaultValues(); // Load default values
				$piso_tecnologico_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$piso_tecnologico_grid->LoadRowValues($piso_tecnologico_grid->Recordset); // Load row values
		}
		$piso_tecnologico->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($piso_tecnologico->CurrentAction == "gridadd") // Grid add
			$piso_tecnologico->RowType = EW_ROWTYPE_ADD; // Render add
		if ($piso_tecnologico->CurrentAction == "gridadd" && $piso_tecnologico->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$piso_tecnologico_grid->RestoreCurrentRowFormValues($piso_tecnologico_grid->RowIndex); // Restore form values
		if ($piso_tecnologico->CurrentAction == "gridedit") { // Grid edit
			if ($piso_tecnologico->EventCancelled) {
				$piso_tecnologico_grid->RestoreCurrentRowFormValues($piso_tecnologico_grid->RowIndex); // Restore form values
			}
			if ($piso_tecnologico_grid->RowAction == "insert")
				$piso_tecnologico->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$piso_tecnologico->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($piso_tecnologico->CurrentAction == "gridedit" && ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT || $piso_tecnologico->RowType == EW_ROWTYPE_ADD) && $piso_tecnologico->EventCancelled) // Update failed
			$piso_tecnologico_grid->RestoreCurrentRowFormValues($piso_tecnologico_grid->RowIndex); // Restore form values
		if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) // Edit row
			$piso_tecnologico_grid->EditRowCnt++;
		if ($piso_tecnologico->CurrentAction == "F") // Confirm row
			$piso_tecnologico_grid->RestoreCurrentRowFormValues($piso_tecnologico_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$piso_tecnologico->RowAttrs = array_merge($piso_tecnologico->RowAttrs, array('data-rowindex'=>$piso_tecnologico_grid->RowCnt, 'id'=>'r' . $piso_tecnologico_grid->RowCnt . '_piso_tecnologico', 'data-rowtype'=>$piso_tecnologico->RowType));

		// Render row
		$piso_tecnologico_grid->RenderRow();

		// Render list options
		$piso_tecnologico_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($piso_tecnologico_grid->RowAction <> "delete" && $piso_tecnologico_grid->RowAction <> "insertdelete" && !($piso_tecnologico_grid->RowAction == "insert" && $piso_tecnologico->CurrentAction == "F" && $piso_tecnologico_grid->EmptyRow())) {
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$piso_tecnologico_grid->ListOptions->Render("body", "left", $piso_tecnologico_grid->RowCnt);
?>
	<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td data-name="Switch"<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Switch") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Switch") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Switch" class="piso_tecnologico_Switch">
<span<?php echo $piso_tecnologico->Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Switch->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
<?php } ?>
<a id="<?php echo $piso_tecnologico_grid->PageObjName . "_row_" . $piso_tecnologico_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->CurrentValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT || $piso_tecnologico->CurrentMode == "edit") { ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->CurrentValue) ?>">
<?php } ?>
	<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
		<td data-name="Bocas_Switch"<?php echo $piso_tecnologico->Bocas_Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch">
<span<?php echo $piso_tecnologico->Bocas_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Bocas_Switch->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td data-name="Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch">
<span<?php echo $piso_tecnologico->Estado_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td data-name="Cantidad_Ap"<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap">
<span<?php echo $piso_tecnologico->Cantidad_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
		<td data-name="Cantidad_Ap_Func"<?php echo $piso_tecnologico->Cantidad_Ap_Func->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func">
<span<?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap_Func->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td data-name="Ups"<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Ups") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Ups") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Ups" class="piso_tecnologico_Ups">
<span<?php echo $piso_tecnologico->Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Ups->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td data-name="Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups">
<span<?php echo $piso_tecnologico->Estado_Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td data-name="Cableado"<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Cableado") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Cableado") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado">
<span<?php echo $piso_tecnologico->Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cableado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td data-name="Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado">
<span<?php echo $piso_tecnologico->Estado_Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td data-name="Porcent_Estado_Cab"<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab">
<span<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td data-name="Porcent_Func_Piso"<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso">
<span<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Func_Piso->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td data-name="Plano_Escuela"<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<?php if ($piso_tecnologico_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="0">
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->OldValue) ?>">
<?php } elseif ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela">
<span<?php echo $piso_tecnologico->Plano_Escuela->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($piso_tecnologico->Plano_Escuela, $piso_tecnologico->Plano_Escuela->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $piso_tecnologico->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion">
<span<?php echo $piso_tecnologico->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $piso_tecnologico->Usuario->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_grid->RowCnt ?>_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario">
<span<?php echo $piso_tecnologico->Usuario->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->FormValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$piso_tecnologico_grid->ListOptions->Render("body", "right", $piso_tecnologico_grid->RowCnt);
?>
	</tr>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD || $piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpiso_tecnologicogrid.UpdateOpts(<?php echo $piso_tecnologico_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($piso_tecnologico->CurrentAction <> "gridadd" || $piso_tecnologico->CurrentMode == "copy")
		if (!$piso_tecnologico_grid->Recordset->EOF) $piso_tecnologico_grid->Recordset->MoveNext();
}
?>
<?php
	if ($piso_tecnologico->CurrentMode == "add" || $piso_tecnologico->CurrentMode == "copy" || $piso_tecnologico->CurrentMode == "edit") {
		$piso_tecnologico_grid->RowIndex = '$rowindex$';
		$piso_tecnologico_grid->LoadDefaultValues();

		// Set row properties
		$piso_tecnologico->ResetAttrs();
		$piso_tecnologico->RowAttrs = array_merge($piso_tecnologico->RowAttrs, array('data-rowindex'=>$piso_tecnologico_grid->RowIndex, 'id'=>'r0_piso_tecnologico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($piso_tecnologico->RowAttrs["class"], "ewTemplate");
		$piso_tecnologico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$piso_tecnologico_grid->RenderRow();

		// Render list options
		$piso_tecnologico_grid->RenderListOptions();
		$piso_tecnologico_grid->StartRowCnt = 0;
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$piso_tecnologico_grid->ListOptions->Render("body", "left", $piso_tecnologico_grid->RowIndex);
?>
	<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td data-name="Switch">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Switch") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<span<?php echo $piso_tecnologico->Switch->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Switch->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
		<td data-name="Bocas_Switch">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<span<?php echo $piso_tecnologico->Bocas_Switch->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Bocas_Switch->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td data-name="Estado_Switch">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<span<?php echo $piso_tecnologico->Estado_Switch->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Estado_Switch->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td data-name="Cantidad_Ap">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<span<?php echo $piso_tecnologico->Cantidad_Ap->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Cantidad_Ap->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
		<td data-name="Cantidad_Ap_Func">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<span<?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td data-name="Ups">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Ups") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<span<?php echo $piso_tecnologico->Ups->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Ups->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td data-name="Estado_Ups">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<span<?php echo $piso_tecnologico->Estado_Ups->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Estado_Ups->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td data-name="Cableado">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_grid->RowIndex}_Cableado") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<span<?php echo $piso_tecnologico->Cableado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Cableado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td data-name="Estado_Cableado">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<span<?php echo $piso_tecnologico->Estado_Cableado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Estado_Cableado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td data-name="Porcent_Estado_Cab">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<span<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td data-name="Porcent_Func_Piso">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<span<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $piso_tecnologico->Porcent_Func_Piso->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td data-name="Plano_Escuela">
<span id="el$rowindex$_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="0">
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Plano_Escuela" value="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($piso_tecnologico->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" id="x<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$piso_tecnologico_grid->ListOptions->Render("body", "right", $piso_tecnologico_grid->RowCnt);
?>
<script type="text/javascript">
fpiso_tecnologicogrid.UpdateOpts(<?php echo $piso_tecnologico_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($piso_tecnologico->CurrentMode == "add" || $piso_tecnologico->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $piso_tecnologico_grid->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_grid->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_grid->KeyCount ?>">
<?php echo $piso_tecnologico_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($piso_tecnologico->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $piso_tecnologico_grid->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_grid->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_grid->KeyCount ?>">
<?php echo $piso_tecnologico_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($piso_tecnologico->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpiso_tecnologicogrid">
</div>
<?php

// Close recordset
if ($piso_tecnologico_grid->Recordset)
	$piso_tecnologico_grid->Recordset->Close();
?>
<?php if ($piso_tecnologico_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($piso_tecnologico_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($piso_tecnologico_grid->TotalRecs == 0 && $piso_tecnologico->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($piso_tecnologico_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">
fpiso_tecnologicogrid.Init();
</script>
<?php } ?>
<?php
$piso_tecnologico_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$piso_tecnologico_grid->Page_Terminate();
?>
