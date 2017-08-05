<?php include_once "referente_tecnicoinfo.php" ?>
<?php

// Create page object
if (!isset($paquetes_provision_grid)) $paquetes_provision_grid = new cpaquetes_provision_grid();

// Page init
$paquetes_provision_grid->Page_Init();

// Page main
$paquetes_provision_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$paquetes_provision_grid->Page_Render();
?>
<?php if ($paquetes_provision->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpaquetes_provisiongrid = new ew_Form("fpaquetes_provisiongrid", "grid");
fpaquetes_provisiongrid.FormKeyCountName = '<?php echo $paquetes_provision_grid->FormKeyCountName ?>';

// Validate form
fpaquetes_provisiongrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->NroSerie->FldCaption(), $paquetes_provision->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Hardware");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Hardware->FldCaption(), $paquetes_provision->Id_Hardware->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->SN->FldCaption(), $paquetes_provision->SN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Marca_Arranque");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Marca_Arranque->FldCaption(), $paquetes_provision->Marca_Arranque->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Motivo->FldCaption(), $paquetes_provision->Id_Motivo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Extraccion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Tipo_Extraccion->FldCaption(), $paquetes_provision->Id_Tipo_Extraccion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Paquete");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Estado_Paquete->FldCaption(), $paquetes_provision->Id_Estado_Paquete->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpaquetes_provisiongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Hardware", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SN", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Marca_Arranque", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Motivo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Extraccion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado_Paquete", false)) return false;
	return true;
}

// Form_CustomValidate event
fpaquetes_provisiongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpaquetes_provisiongrid.ValidateRequired = true;
<?php } else { ?>
fpaquetes_provisiongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpaquetes_provisiongrid.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":true,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisiongrid.Lists["x_Id_Hardware"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisiongrid.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpaquetes_provisiongrid.Lists["x_Id_Tipo_Extraccion"] = {"LinkField":"x_Id_Tipo_Extraccion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpaquetes_provisiongrid.Lists["x_Id_Estado_Paquete"] = {"LinkField":"x_Id_Estado_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_paquete"};

// Form object for search
</script>
<?php } ?>
<?php
if ($paquetes_provision->CurrentAction == "gridadd") {
	if ($paquetes_provision->CurrentMode == "copy") {
		$bSelectLimit = $paquetes_provision_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$paquetes_provision_grid->TotalRecs = $paquetes_provision->SelectRecordCount();
			$paquetes_provision_grid->Recordset = $paquetes_provision_grid->LoadRecordset($paquetes_provision_grid->StartRec-1, $paquetes_provision_grid->DisplayRecs);
		} else {
			if ($paquetes_provision_grid->Recordset = $paquetes_provision_grid->LoadRecordset())
				$paquetes_provision_grid->TotalRecs = $paquetes_provision_grid->Recordset->RecordCount();
		}
		$paquetes_provision_grid->StartRec = 1;
		$paquetes_provision_grid->DisplayRecs = $paquetes_provision_grid->TotalRecs;
	} else {
		$paquetes_provision->CurrentFilter = "0=1";
		$paquetes_provision_grid->StartRec = 1;
		$paquetes_provision_grid->DisplayRecs = $paquetes_provision->GridAddRowCount;
	}
	$paquetes_provision_grid->TotalRecs = $paquetes_provision_grid->DisplayRecs;
	$paquetes_provision_grid->StopRec = $paquetes_provision_grid->DisplayRecs;
} else {
	$bSelectLimit = $paquetes_provision_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($paquetes_provision_grid->TotalRecs <= 0)
			$paquetes_provision_grid->TotalRecs = $paquetes_provision->SelectRecordCount();
	} else {
		if (!$paquetes_provision_grid->Recordset && ($paquetes_provision_grid->Recordset = $paquetes_provision_grid->LoadRecordset()))
			$paquetes_provision_grid->TotalRecs = $paquetes_provision_grid->Recordset->RecordCount();
	}
	$paquetes_provision_grid->StartRec = 1;
	$paquetes_provision_grid->DisplayRecs = $paquetes_provision_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$paquetes_provision_grid->Recordset = $paquetes_provision_grid->LoadRecordset($paquetes_provision_grid->StartRec-1, $paquetes_provision_grid->DisplayRecs);

	// Set no record found message
	if ($paquetes_provision->CurrentAction == "" && $paquetes_provision_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$paquetes_provision_grid->setWarningMessage(ew_DeniedMsg());
		if ($paquetes_provision_grid->SearchWhere == "0=101")
			$paquetes_provision_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$paquetes_provision_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$paquetes_provision_grid->RenderOtherOptions();
?>
<?php $paquetes_provision_grid->ShowPageHeader(); ?>
<?php
$paquetes_provision_grid->ShowMessage();
?>
<?php if ($paquetes_provision_grid->TotalRecs > 0 || $paquetes_provision->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid paquetes_provision">
<div id="fpaquetes_provisiongrid" class="ewForm form-inline">
<div id="gmp_paquetes_provision" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_paquetes_provisiongrid" class="table ewTable">
<?php echo $paquetes_provision->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$paquetes_provision_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$paquetes_provision_grid->RenderListOptions();

// Render list options (header, left)
$paquetes_provision_grid->ListOptions->Render("header", "left");
?>
<?php if ($paquetes_provision->NroSerie->Visible) { // NroSerie ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_paquetes_provision_NroSerie" class="paquetes_provision_NroSerie"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div><div id="elh_paquetes_provision_NroSerie" class="paquetes_provision_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->NroSerie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Hardware) == "") { ?>
		<th data-name="Id_Hardware"><div id="elh_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Hardware"><div><div id="elh_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Hardware->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Hardware->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->SN->Visible) { // SN ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->SN) == "") { ?>
		<th data-name="SN"><div id="elh_paquetes_provision_SN" class="paquetes_provision_SN"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->SN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SN"><div><div id="elh_paquetes_provision_SN" class="paquetes_provision_SN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->SN->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->SN->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->SN->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Marca_Arranque) == "") { ?>
		<th data-name="Marca_Arranque"><div id="elh_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Marca_Arranque"><div><div id="elh_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Marca_Arranque->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Marca_Arranque->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Motivo) == "") { ?>
		<th data-name="Id_Motivo"><div id="elh_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Motivo"><div><div id="elh_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Motivo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Motivo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Tipo_Extraccion) == "") { ?>
		<th data-name="Id_Tipo_Extraccion"><div id="elh_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Extraccion"><div><div id="elh_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Tipo_Extraccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Tipo_Extraccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Estado_Paquete) == "") { ?>
		<th data-name="Id_Estado_Paquete"><div id="elh_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Paquete"><div><div id="elh_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Estado_Paquete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Estado_Paquete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Fecha_Actulizacion->Visible) { // Fecha_Actulizacion ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Fecha_Actulizacion) == "") { ?>
		<th data-name="Fecha_Actulizacion"><div id="elh_paquetes_provision_Fecha_Actulizacion" class="paquetes_provision_Fecha_Actulizacion"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Fecha_Actulizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actulizacion"><div><div id="elh_paquetes_provision_Fecha_Actulizacion" class="paquetes_provision_Fecha_Actulizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Fecha_Actulizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Fecha_Actulizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Fecha_Actulizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_paquetes_provision_Usuario" class="paquetes_provision_Usuario"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_paquetes_provision_Usuario" class="paquetes_provision_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$paquetes_provision_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$paquetes_provision_grid->StartRec = 1;
$paquetes_provision_grid->StopRec = $paquetes_provision_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($paquetes_provision_grid->FormKeyCountName) && ($paquetes_provision->CurrentAction == "gridadd" || $paquetes_provision->CurrentAction == "gridedit" || $paquetes_provision->CurrentAction == "F")) {
		$paquetes_provision_grid->KeyCount = $objForm->GetValue($paquetes_provision_grid->FormKeyCountName);
		$paquetes_provision_grid->StopRec = $paquetes_provision_grid->StartRec + $paquetes_provision_grid->KeyCount - 1;
	}
}
$paquetes_provision_grid->RecCnt = $paquetes_provision_grid->StartRec - 1;
if ($paquetes_provision_grid->Recordset && !$paquetes_provision_grid->Recordset->EOF) {
	$paquetes_provision_grid->Recordset->MoveFirst();
	$bSelectLimit = $paquetes_provision_grid->UseSelectLimit;
	if (!$bSelectLimit && $paquetes_provision_grid->StartRec > 1)
		$paquetes_provision_grid->Recordset->Move($paquetes_provision_grid->StartRec - 1);
} elseif (!$paquetes_provision->AllowAddDeleteRow && $paquetes_provision_grid->StopRec == 0) {
	$paquetes_provision_grid->StopRec = $paquetes_provision->GridAddRowCount;
}

// Initialize aggregate
$paquetes_provision->RowType = EW_ROWTYPE_AGGREGATEINIT;
$paquetes_provision->ResetAttrs();
$paquetes_provision_grid->RenderRow();
if ($paquetes_provision->CurrentAction == "gridadd")
	$paquetes_provision_grid->RowIndex = 0;
if ($paquetes_provision->CurrentAction == "gridedit")
	$paquetes_provision_grid->RowIndex = 0;
while ($paquetes_provision_grid->RecCnt < $paquetes_provision_grid->StopRec) {
	$paquetes_provision_grid->RecCnt++;
	if (intval($paquetes_provision_grid->RecCnt) >= intval($paquetes_provision_grid->StartRec)) {
		$paquetes_provision_grid->RowCnt++;
		if ($paquetes_provision->CurrentAction == "gridadd" || $paquetes_provision->CurrentAction == "gridedit" || $paquetes_provision->CurrentAction == "F") {
			$paquetes_provision_grid->RowIndex++;
			$objForm->Index = $paquetes_provision_grid->RowIndex;
			if ($objForm->HasValue($paquetes_provision_grid->FormActionName))
				$paquetes_provision_grid->RowAction = strval($objForm->GetValue($paquetes_provision_grid->FormActionName));
			elseif ($paquetes_provision->CurrentAction == "gridadd")
				$paquetes_provision_grid->RowAction = "insert";
			else
				$paquetes_provision_grid->RowAction = "";
		}

		// Set up key count
		$paquetes_provision_grid->KeyCount = $paquetes_provision_grid->RowIndex;

		// Init row class and style
		$paquetes_provision->ResetAttrs();
		$paquetes_provision->CssClass = "";
		if ($paquetes_provision->CurrentAction == "gridadd") {
			if ($paquetes_provision->CurrentMode == "copy") {
				$paquetes_provision_grid->LoadRowValues($paquetes_provision_grid->Recordset); // Load row values
				$paquetes_provision_grid->SetRecordKey($paquetes_provision_grid->RowOldKey, $paquetes_provision_grid->Recordset); // Set old record key
			} else {
				$paquetes_provision_grid->LoadDefaultValues(); // Load default values
				$paquetes_provision_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$paquetes_provision_grid->LoadRowValues($paquetes_provision_grid->Recordset); // Load row values
		}
		$paquetes_provision->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($paquetes_provision->CurrentAction == "gridadd") // Grid add
			$paquetes_provision->RowType = EW_ROWTYPE_ADD; // Render add
		if ($paquetes_provision->CurrentAction == "gridadd" && $paquetes_provision->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$paquetes_provision_grid->RestoreCurrentRowFormValues($paquetes_provision_grid->RowIndex); // Restore form values
		if ($paquetes_provision->CurrentAction == "gridedit") { // Grid edit
			if ($paquetes_provision->EventCancelled) {
				$paquetes_provision_grid->RestoreCurrentRowFormValues($paquetes_provision_grid->RowIndex); // Restore form values
			}
			if ($paquetes_provision_grid->RowAction == "insert")
				$paquetes_provision->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$paquetes_provision->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($paquetes_provision->CurrentAction == "gridedit" && ($paquetes_provision->RowType == EW_ROWTYPE_EDIT || $paquetes_provision->RowType == EW_ROWTYPE_ADD) && $paquetes_provision->EventCancelled) // Update failed
			$paquetes_provision_grid->RestoreCurrentRowFormValues($paquetes_provision_grid->RowIndex); // Restore form values
		if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) // Edit row
			$paquetes_provision_grid->EditRowCnt++;
		if ($paquetes_provision->CurrentAction == "F") // Confirm row
			$paquetes_provision_grid->RestoreCurrentRowFormValues($paquetes_provision_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$paquetes_provision->RowAttrs = array_merge($paquetes_provision->RowAttrs, array('data-rowindex'=>$paquetes_provision_grid->RowCnt, 'id'=>'r' . $paquetes_provision_grid->RowCnt . '_paquetes_provision', 'data-rowtype'=>$paquetes_provision->RowType));

		// Render row
		$paquetes_provision_grid->RenderRow();

		// Render list options
		$paquetes_provision_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($paquetes_provision_grid->RowAction <> "delete" && $paquetes_provision_grid->RowAction <> "insertdelete" && !($paquetes_provision_grid->RowAction == "insert" && $paquetes_provision->CurrentAction == "F" && $paquetes_provision_grid->EmptyRow())) {
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php

// Render list options (body, left)
$paquetes_provision_grid->ListOptions->Render("body", "left", $paquetes_provision_grid->RowCnt);
?>
	<?php if ($paquetes_provision->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $paquetes_provision->NroSerie->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($paquetes_provision->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<span<?php echo $paquetes_provision->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<?php $paquetes_provision->NroSerie->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->NroSerie->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><?php echo (strval($paquetes_provision->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->CurrentValue ?>"<?php echo $paquetes_provision->NroSerie->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->NroSerie->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_grid->RowIndex ?>_SN">
</span>
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($paquetes_provision->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<span<?php echo $paquetes_provision->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<?php $paquetes_provision->NroSerie->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->NroSerie->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><?php echo (strval($paquetes_provision->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->CurrentValue ?>"<?php echo $paquetes_provision->NroSerie->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->NroSerie->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_grid->RowIndex ?>_SN">
</span>
<?php } ?>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_NroSerie" class="paquetes_provision_NroSerie">
<span<?php echo $paquetes_provision->NroSerie->ViewAttributes() ?>>
<?php echo $paquetes_provision->NroSerie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->OldValue) ?>">
<?php } ?>
<a id="<?php echo $paquetes_provision_grid->PageObjName . "_row_" . $paquetes_provision_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->CurrentValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT || $paquetes_provision->CurrentMode == "edit") { ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->CurrentValue) ?>">
<?php } ?>
	<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware"<?php echo $paquetes_provision->Id_Hardware->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisiongrid.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisiongrid.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware">
<span<?php echo $paquetes_provision->Id_Hardware->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Hardware->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td data-name="SN"<?php echo $paquetes_provision->SN->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_SN" class="paquetes_provision_SN">
<span<?php echo $paquetes_provision->SN->ViewAttributes() ?>>
<?php echo $paquetes_provision->SN->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque"<?php echo $paquetes_provision->Marca_Arranque->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque">
<span<?php echo $paquetes_provision->Marca_Arranque->ViewAttributes() ?>>
<?php echo $paquetes_provision->Marca_Arranque->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo">
<span<?php echo $paquetes_provision->Id_Motivo->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion">
<span<?php echo $paquetes_provision->Id_Tipo_Extraccion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete">
<span<?php echo $paquetes_provision->Id_Estado_Paquete->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Fecha_Actulizacion->Visible) { // Fecha_Actulizacion ?>
		<td data-name="Fecha_Actulizacion"<?php echo $paquetes_provision->Fecha_Actulizacion->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actulizacion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actulizacion->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Fecha_Actulizacion" class="paquetes_provision_Fecha_Actulizacion">
<span<?php echo $paquetes_provision->Fecha_Actulizacion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Fecha_Actulizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actulizacion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actulizacion->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actulizacion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actulizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $paquetes_provision->Usuario->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_grid->RowCnt ?>_paquetes_provision_Usuario" class="paquetes_provision_Usuario">
<span<?php echo $paquetes_provision->Usuario->ViewAttributes() ?>>
<?php echo $paquetes_provision->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->FormValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$paquetes_provision_grid->ListOptions->Render("body", "right", $paquetes_provision_grid->RowCnt);
?>
	</tr>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD || $paquetes_provision->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpaquetes_provisiongrid.UpdateOpts(<?php echo $paquetes_provision_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($paquetes_provision->CurrentAction <> "gridadd" || $paquetes_provision->CurrentMode == "copy")
		if (!$paquetes_provision_grid->Recordset->EOF) $paquetes_provision_grid->Recordset->MoveNext();
}
?>
<?php
	if ($paquetes_provision->CurrentMode == "add" || $paquetes_provision->CurrentMode == "copy" || $paquetes_provision->CurrentMode == "edit") {
		$paquetes_provision_grid->RowIndex = '$rowindex$';
		$paquetes_provision_grid->LoadDefaultValues();

		// Set row properties
		$paquetes_provision->ResetAttrs();
		$paquetes_provision->RowAttrs = array_merge($paquetes_provision->RowAttrs, array('data-rowindex'=>$paquetes_provision_grid->RowIndex, 'id'=>'r0_paquetes_provision', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($paquetes_provision->RowAttrs["class"], "ewTemplate");
		$paquetes_provision->RowType = EW_ROWTYPE_ADD;

		// Render row
		$paquetes_provision_grid->RenderRow();

		// Render list options
		$paquetes_provision_grid->RenderListOptions();
		$paquetes_provision_grid->StartRowCnt = 0;
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php

// Render list options (body, left)
$paquetes_provision_grid->ListOptions->Render("body", "left", $paquetes_provision_grid->RowIndex);
?>
	<?php if ($paquetes_provision->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<?php if ($paquetes_provision->NroSerie->getSessionValue() <> "") { ?>
<span id="el$rowindex$_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<span<?php echo $paquetes_provision->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<?php $paquetes_provision->NroSerie->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->NroSerie->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><?php echo (strval($paquetes_provision->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->CurrentValue ?>"<?php echo $paquetes_provision->NroSerie->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->NroSerie->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo $paquetes_provision->NroSerie->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="ln_x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_grid->RowIndex ?>_SN">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_NroSerie" class="form-group paquetes_provision_NroSerie">
<span<?php echo $paquetes_provision->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroSerie" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($paquetes_provision->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisiongrid.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<span<?php echo $paquetes_provision->Id_Hardware->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->Id_Hardware->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td data-name="SN">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<span<?php echo $paquetes_provision->SN->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->SN->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<span<?php echo $paquetes_provision->Marca_Arranque->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->Marca_Arranque->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<span<?php echo $paquetes_provision->Id_Motivo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->Id_Motivo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<span<?php echo $paquetes_provision->Id_Tipo_Extraccion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->Id_Tipo_Extraccion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<span id="el$rowindex$_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<span<?php echo $paquetes_provision->Id_Estado_Paquete->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $paquetes_provision->Id_Estado_Paquete->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Fecha_Actulizacion->Visible) { // Fecha_Actulizacion ?>
		<td data-name="Fecha_Actulizacion">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actulizacion" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actulizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actulizacion" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Fecha_Actulizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actulizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($paquetes_provision->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="x<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" id="x<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$paquetes_provision_grid->ListOptions->Render("body", "right", $paquetes_provision_grid->RowCnt);
?>
<script type="text/javascript">
fpaquetes_provisiongrid.UpdateOpts(<?php echo $paquetes_provision_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($paquetes_provision->CurrentMode == "add" || $paquetes_provision->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $paquetes_provision_grid->FormKeyCountName ?>" id="<?php echo $paquetes_provision_grid->FormKeyCountName ?>" value="<?php echo $paquetes_provision_grid->KeyCount ?>">
<?php echo $paquetes_provision_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($paquetes_provision->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $paquetes_provision_grid->FormKeyCountName ?>" id="<?php echo $paquetes_provision_grid->FormKeyCountName ?>" value="<?php echo $paquetes_provision_grid->KeyCount ?>">
<?php echo $paquetes_provision_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($paquetes_provision->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpaquetes_provisiongrid">
</div>
<?php

// Close recordset
if ($paquetes_provision_grid->Recordset)
	$paquetes_provision_grid->Recordset->Close();
?>
<?php if ($paquetes_provision_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($paquetes_provision_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($paquetes_provision_grid->TotalRecs == 0 && $paquetes_provision->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($paquetes_provision_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($paquetes_provision->Export == "") { ?>
<script type="text/javascript">
fpaquetes_provisiongrid.Init();
</script>
<?php } ?>
<?php
$paquetes_provision_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$paquetes_provision_grid->Page_Terminate();
?>
