<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($chat_grid)) $chat_grid = new cchat_grid();

// Page init
$chat_grid->Page_Init();

// Page main
$chat_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$chat_grid->Page_Render();
?>
<?php if ($chat->Export == "") { ?>
<script type="text/javascript">

// Form object
var fchatgrid = new ew_Form("fchatgrid", "grid");
fchatgrid.FormKeyCountName = '<?php echo $chat_grid->FormKeyCountName ?>';

// Validate form
fchatgrid.Validate = function() {
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
fchatgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Texto_Chat", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fchatgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fchatgrid.ValidateRequired = true;
<?php } else { ?>
fchatgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($chat->CurrentAction == "gridadd") {
	if ($chat->CurrentMode == "copy") {
		$bSelectLimit = $chat_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$chat_grid->TotalRecs = $chat->SelectRecordCount();
			$chat_grid->Recordset = $chat_grid->LoadRecordset($chat_grid->StartRec-1, $chat_grid->DisplayRecs);
		} else {
			if ($chat_grid->Recordset = $chat_grid->LoadRecordset())
				$chat_grid->TotalRecs = $chat_grid->Recordset->RecordCount();
		}
		$chat_grid->StartRec = 1;
		$chat_grid->DisplayRecs = $chat_grid->TotalRecs;
	} else {
		$chat->CurrentFilter = "0=1";
		$chat_grid->StartRec = 1;
		$chat_grid->DisplayRecs = $chat->GridAddRowCount;
	}
	$chat_grid->TotalRecs = $chat_grid->DisplayRecs;
	$chat_grid->StopRec = $chat_grid->DisplayRecs;
} else {
	$bSelectLimit = $chat_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($chat_grid->TotalRecs <= 0)
			$chat_grid->TotalRecs = $chat->SelectRecordCount();
	} else {
		if (!$chat_grid->Recordset && ($chat_grid->Recordset = $chat_grid->LoadRecordset()))
			$chat_grid->TotalRecs = $chat_grid->Recordset->RecordCount();
	}
	$chat_grid->StartRec = 1;
	$chat_grid->DisplayRecs = $chat_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$chat_grid->Recordset = $chat_grid->LoadRecordset($chat_grid->StartRec-1, $chat_grid->DisplayRecs);

	// Set no record found message
	if ($chat->CurrentAction == "" && $chat_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$chat_grid->setWarningMessage(ew_DeniedMsg());
		if ($chat_grid->SearchWhere == "0=101")
			$chat_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$chat_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$chat_grid->RenderOtherOptions();
?>
<?php $chat_grid->ShowPageHeader(); ?>
<?php
$chat_grid->ShowMessage();
?>
<?php if ($chat_grid->TotalRecs > 0 || $chat->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid chat">
<div id="fchatgrid" class="ewForm form-inline">
<?php if ($chat_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($chat_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_chat" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_chatgrid" class="table ewTable">
<?php echo $chat->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$chat_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$chat_grid->RenderListOptions();

// Render list options (header, left)
$chat_grid->ListOptions->Render("header", "left");
?>
<?php if ($chat->Texto_Chat->Visible) { // Texto_Chat ?>
	<?php if ($chat->SortUrl($chat->Texto_Chat) == "") { ?>
		<th data-name="Texto_Chat"><div id="elh_chat_Texto_Chat" class="chat_Texto_Chat"><div class="ewTableHeaderCaption"><?php echo $chat->Texto_Chat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Texto_Chat"><div><div id="elh_chat_Texto_Chat" class="chat_Texto_Chat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $chat->Texto_Chat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($chat->Texto_Chat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($chat->Texto_Chat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($chat->Hora->Visible) { // Hora ?>
	<?php if ($chat->SortUrl($chat->Hora) == "") { ?>
		<th data-name="Hora"><div id="elh_chat_Hora" class="chat_Hora"><div class="ewTableHeaderCaption"><?php echo $chat->Hora->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Hora"><div><div id="elh_chat_Hora" class="chat_Hora">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $chat->Hora->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($chat->Hora->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($chat->Hora->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($chat->Usuario->Visible) { // Usuario ?>
	<?php if ($chat->SortUrl($chat->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_chat_Usuario" class="chat_Usuario"><div class="ewTableHeaderCaption"><?php echo $chat->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_chat_Usuario" class="chat_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $chat->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($chat->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($chat->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($chat->Estado->Visible) { // Estado ?>
	<?php if ($chat->SortUrl($chat->Estado) == "") { ?>
		<th data-name="Estado"><div id="elh_chat_Estado" class="chat_Estado"><div class="ewTableHeaderCaption"><?php echo $chat->Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado"><div><div id="elh_chat_Estado" class="chat_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $chat->Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($chat->Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($chat->Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$chat_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$chat_grid->StartRec = 1;
$chat_grid->StopRec = $chat_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($chat_grid->FormKeyCountName) && ($chat->CurrentAction == "gridadd" || $chat->CurrentAction == "gridedit" || $chat->CurrentAction == "F")) {
		$chat_grid->KeyCount = $objForm->GetValue($chat_grid->FormKeyCountName);
		$chat_grid->StopRec = $chat_grid->StartRec + $chat_grid->KeyCount - 1;
	}
}
$chat_grid->RecCnt = $chat_grid->StartRec - 1;
if ($chat_grid->Recordset && !$chat_grid->Recordset->EOF) {
	$chat_grid->Recordset->MoveFirst();
	$bSelectLimit = $chat_grid->UseSelectLimit;
	if (!$bSelectLimit && $chat_grid->StartRec > 1)
		$chat_grid->Recordset->Move($chat_grid->StartRec - 1);
} elseif (!$chat->AllowAddDeleteRow && $chat_grid->StopRec == 0) {
	$chat_grid->StopRec = $chat->GridAddRowCount;
}

// Initialize aggregate
$chat->RowType = EW_ROWTYPE_AGGREGATEINIT;
$chat->ResetAttrs();
$chat_grid->RenderRow();
if ($chat->CurrentAction == "gridadd")
	$chat_grid->RowIndex = 0;
if ($chat->CurrentAction == "gridedit")
	$chat_grid->RowIndex = 0;
while ($chat_grid->RecCnt < $chat_grid->StopRec) {
	$chat_grid->RecCnt++;
	if (intval($chat_grid->RecCnt) >= intval($chat_grid->StartRec)) {
		$chat_grid->RowCnt++;
		if ($chat->CurrentAction == "gridadd" || $chat->CurrentAction == "gridedit" || $chat->CurrentAction == "F") {
			$chat_grid->RowIndex++;
			$objForm->Index = $chat_grid->RowIndex;
			if ($objForm->HasValue($chat_grid->FormActionName))
				$chat_grid->RowAction = strval($objForm->GetValue($chat_grid->FormActionName));
			elseif ($chat->CurrentAction == "gridadd")
				$chat_grid->RowAction = "insert";
			else
				$chat_grid->RowAction = "";
		}

		// Set up key count
		$chat_grid->KeyCount = $chat_grid->RowIndex;

		// Init row class and style
		$chat->ResetAttrs();
		$chat->CssClass = "";
		if ($chat->CurrentAction == "gridadd") {
			if ($chat->CurrentMode == "copy") {
				$chat_grid->LoadRowValues($chat_grid->Recordset); // Load row values
				$chat_grid->SetRecordKey($chat_grid->RowOldKey, $chat_grid->Recordset); // Set old record key
			} else {
				$chat_grid->LoadDefaultValues(); // Load default values
				$chat_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$chat_grid->LoadRowValues($chat_grid->Recordset); // Load row values
		}
		$chat->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($chat->CurrentAction == "gridadd") // Grid add
			$chat->RowType = EW_ROWTYPE_ADD; // Render add
		if ($chat->CurrentAction == "gridadd" && $chat->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$chat_grid->RestoreCurrentRowFormValues($chat_grid->RowIndex); // Restore form values
		if ($chat->CurrentAction == "gridedit") { // Grid edit
			if ($chat->EventCancelled) {
				$chat_grid->RestoreCurrentRowFormValues($chat_grid->RowIndex); // Restore form values
			}
			if ($chat_grid->RowAction == "insert")
				$chat->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$chat->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($chat->CurrentAction == "gridedit" && ($chat->RowType == EW_ROWTYPE_EDIT || $chat->RowType == EW_ROWTYPE_ADD) && $chat->EventCancelled) // Update failed
			$chat_grid->RestoreCurrentRowFormValues($chat_grid->RowIndex); // Restore form values
		if ($chat->RowType == EW_ROWTYPE_EDIT) // Edit row
			$chat_grid->EditRowCnt++;
		if ($chat->CurrentAction == "F") // Confirm row
			$chat_grid->RestoreCurrentRowFormValues($chat_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$chat->RowAttrs = array_merge($chat->RowAttrs, array('data-rowindex'=>$chat_grid->RowCnt, 'id'=>'r' . $chat_grid->RowCnt . '_chat', 'data-rowtype'=>$chat->RowType));

		// Render row
		$chat_grid->RenderRow();

		// Render list options
		$chat_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($chat_grid->RowAction <> "delete" && $chat_grid->RowAction <> "insertdelete" && !($chat_grid->RowAction == "insert" && $chat->CurrentAction == "F" && $chat_grid->EmptyRow())) {
?>
	<tr<?php echo $chat->RowAttributes() ?>>
<?php

// Render list options (body, left)
$chat_grid->ListOptions->Render("body", "left", $chat_grid->RowCnt);
?>
	<?php if ($chat->Texto_Chat->Visible) { // Texto_Chat ?>
		<td data-name="Texto_Chat"<?php echo $chat->Texto_Chat->CellAttributes() ?>>
<?php if ($chat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Texto_Chat" class="form-group chat_Texto_Chat">
<textarea data-table="chat" data-field="x_Texto_Chat" name="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($chat->Texto_Chat->getPlaceHolder()) ?>"<?php echo $chat->Texto_Chat->EditAttributes() ?>><?php echo $chat->Texto_Chat->EditValue ?></textarea>
</span>
<input type="hidden" data-table="chat" data-field="x_Texto_Chat" name="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" value="<?php echo ew_HtmlEncode($chat->Texto_Chat->OldValue) ?>">
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Texto_Chat" class="form-group chat_Texto_Chat">
<textarea data-table="chat" data-field="x_Texto_Chat" name="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($chat->Texto_Chat->getPlaceHolder()) ?>"<?php echo $chat->Texto_Chat->EditAttributes() ?>><?php echo $chat->Texto_Chat->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Texto_Chat" class="chat_Texto_Chat">
<span<?php echo $chat->Texto_Chat->ViewAttributes() ?>>
<?php echo $chat->Texto_Chat->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Texto_Chat" name="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" value="<?php echo ew_HtmlEncode($chat->Texto_Chat->FormValue) ?>">
<input type="hidden" data-table="chat" data-field="x_Texto_Chat" name="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" value="<?php echo ew_HtmlEncode($chat->Texto_Chat->OldValue) ?>">
<?php } ?>
<a id="<?php echo $chat_grid->PageObjName . "_row_" . $chat_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="chat" data-field="x_Orden" name="x<?php echo $chat_grid->RowIndex ?>_Orden" id="x<?php echo $chat_grid->RowIndex ?>_Orden" value="<?php echo ew_HtmlEncode($chat->Orden->CurrentValue) ?>">
<input type="hidden" data-table="chat" data-field="x_Orden" name="o<?php echo $chat_grid->RowIndex ?>_Orden" id="o<?php echo $chat_grid->RowIndex ?>_Orden" value="<?php echo ew_HtmlEncode($chat->Orden->OldValue) ?>">
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_EDIT || $chat->CurrentMode == "edit") { ?>
<input type="hidden" data-table="chat" data-field="x_Orden" name="x<?php echo $chat_grid->RowIndex ?>_Orden" id="x<?php echo $chat_grid->RowIndex ?>_Orden" value="<?php echo ew_HtmlEncode($chat->Orden->CurrentValue) ?>">
<?php } ?>
	<?php if ($chat->Hora->Visible) { // Hora ?>
		<td data-name="Hora"<?php echo $chat->Hora->CellAttributes() ?>>
<?php if ($chat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="chat" data-field="x_Hora" name="o<?php echo $chat_grid->RowIndex ?>_Hora" id="o<?php echo $chat_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($chat->Hora->OldValue) ?>">
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Hora" class="chat_Hora">
<span<?php echo $chat->Hora->ViewAttributes() ?>>
<?php echo $chat->Hora->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Hora" name="x<?php echo $chat_grid->RowIndex ?>_Hora" id="x<?php echo $chat_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($chat->Hora->FormValue) ?>">
<input type="hidden" data-table="chat" data-field="x_Hora" name="o<?php echo $chat_grid->RowIndex ?>_Hora" id="o<?php echo $chat_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($chat->Hora->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($chat->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $chat->Usuario->CellAttributes() ?>>
<?php if ($chat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="chat" data-field="x_Usuario" name="o<?php echo $chat_grid->RowIndex ?>_Usuario" id="o<?php echo $chat_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($chat->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Usuario" class="chat_Usuario">
<span<?php echo $chat->Usuario->ViewAttributes() ?>>
<?php echo $chat->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Usuario" name="x<?php echo $chat_grid->RowIndex ?>_Usuario" id="x<?php echo $chat_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($chat->Usuario->FormValue) ?>">
<input type="hidden" data-table="chat" data-field="x_Usuario" name="o<?php echo $chat_grid->RowIndex ?>_Usuario" id="o<?php echo $chat_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($chat->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($chat->Estado->Visible) { // Estado ?>
		<td data-name="Estado"<?php echo $chat->Estado->CellAttributes() ?>>
<?php if ($chat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Estado" class="form-group chat_Estado">
<input type="hidden" data-table="chat" data-field="x_Estado" name="x<?php echo $chat_grid->RowIndex ?>_Estado" id="x<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->CurrentValue) ?>">
</span>
<input type="hidden" data-table="chat" data-field="x_Estado" name="o<?php echo $chat_grid->RowIndex ?>_Estado" id="o<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->OldValue) ?>">
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Estado" class="form-group chat_Estado">
<input type="hidden" data-table="chat" data-field="x_Estado" name="x<?php echo $chat_grid->RowIndex ?>_Estado" id="x<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($chat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $chat_grid->RowCnt ?>_chat_Estado" class="chat_Estado">
<span<?php echo $chat->Estado->ViewAttributes() ?>>
<?php echo $chat->Estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Estado" name="x<?php echo $chat_grid->RowIndex ?>_Estado" id="x<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->FormValue) ?>">
<input type="hidden" data-table="chat" data-field="x_Estado" name="o<?php echo $chat_grid->RowIndex ?>_Estado" id="o<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$chat_grid->ListOptions->Render("body", "right", $chat_grid->RowCnt);
?>
	</tr>
<?php if ($chat->RowType == EW_ROWTYPE_ADD || $chat->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fchatgrid.UpdateOpts(<?php echo $chat_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($chat->CurrentAction <> "gridadd" || $chat->CurrentMode == "copy")
		if (!$chat_grid->Recordset->EOF) $chat_grid->Recordset->MoveNext();
}
?>
<?php
	if ($chat->CurrentMode == "add" || $chat->CurrentMode == "copy" || $chat->CurrentMode == "edit") {
		$chat_grid->RowIndex = '$rowindex$';
		$chat_grid->LoadDefaultValues();

		// Set row properties
		$chat->ResetAttrs();
		$chat->RowAttrs = array_merge($chat->RowAttrs, array('data-rowindex'=>$chat_grid->RowIndex, 'id'=>'r0_chat', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($chat->RowAttrs["class"], "ewTemplate");
		$chat->RowType = EW_ROWTYPE_ADD;

		// Render row
		$chat_grid->RenderRow();

		// Render list options
		$chat_grid->RenderListOptions();
		$chat_grid->StartRowCnt = 0;
?>
	<tr<?php echo $chat->RowAttributes() ?>>
<?php

// Render list options (body, left)
$chat_grid->ListOptions->Render("body", "left", $chat_grid->RowIndex);
?>
	<?php if ($chat->Texto_Chat->Visible) { // Texto_Chat ?>
		<td data-name="Texto_Chat">
<?php if ($chat->CurrentAction <> "F") { ?>
<span id="el$rowindex$_chat_Texto_Chat" class="form-group chat_Texto_Chat">
<textarea data-table="chat" data-field="x_Texto_Chat" name="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($chat->Texto_Chat->getPlaceHolder()) ?>"<?php echo $chat->Texto_Chat->EditAttributes() ?>><?php echo $chat->Texto_Chat->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_chat_Texto_Chat" class="form-group chat_Texto_Chat">
<span<?php echo $chat->Texto_Chat->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $chat->Texto_Chat->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Texto_Chat" name="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="x<?php echo $chat_grid->RowIndex ?>_Texto_Chat" value="<?php echo ew_HtmlEncode($chat->Texto_Chat->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="chat" data-field="x_Texto_Chat" name="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" id="o<?php echo $chat_grid->RowIndex ?>_Texto_Chat" value="<?php echo ew_HtmlEncode($chat->Texto_Chat->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($chat->Hora->Visible) { // Hora ?>
		<td data-name="Hora">
<?php if ($chat->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_chat_Hora" class="form-group chat_Hora">
<span<?php echo $chat->Hora->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $chat->Hora->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Hora" name="x<?php echo $chat_grid->RowIndex ?>_Hora" id="x<?php echo $chat_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($chat->Hora->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="chat" data-field="x_Hora" name="o<?php echo $chat_grid->RowIndex ?>_Hora" id="o<?php echo $chat_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($chat->Hora->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($chat->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($chat->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_chat_Usuario" class="form-group chat_Usuario">
<span<?php echo $chat->Usuario->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $chat->Usuario->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="chat" data-field="x_Usuario" name="x<?php echo $chat_grid->RowIndex ?>_Usuario" id="x<?php echo $chat_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($chat->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="chat" data-field="x_Usuario" name="o<?php echo $chat_grid->RowIndex ?>_Usuario" id="o<?php echo $chat_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($chat->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($chat->Estado->Visible) { // Estado ?>
		<td data-name="Estado">
<?php if ($chat->CurrentAction <> "F") { ?>
<span id="el$rowindex$_chat_Estado" class="form-group chat_Estado">
<input type="hidden" data-table="chat" data-field="x_Estado" name="x<?php echo $chat_grid->RowIndex ?>_Estado" id="x<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->CurrentValue) ?>">
</span>
<?php } else { ?>
<input type="hidden" data-table="chat" data-field="x_Estado" name="x<?php echo $chat_grid->RowIndex ?>_Estado" id="x<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="chat" data-field="x_Estado" name="o<?php echo $chat_grid->RowIndex ?>_Estado" id="o<?php echo $chat_grid->RowIndex ?>_Estado" value="<?php echo ew_HtmlEncode($chat->Estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$chat_grid->ListOptions->Render("body", "right", $chat_grid->RowCnt);
?>
<script type="text/javascript">
fchatgrid.UpdateOpts(<?php echo $chat_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($chat->CurrentMode == "add" || $chat->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $chat_grid->FormKeyCountName ?>" id="<?php echo $chat_grid->FormKeyCountName ?>" value="<?php echo $chat_grid->KeyCount ?>">
<?php echo $chat_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($chat->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $chat_grid->FormKeyCountName ?>" id="<?php echo $chat_grid->FormKeyCountName ?>" value="<?php echo $chat_grid->KeyCount ?>">
<?php echo $chat_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($chat->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fchatgrid">
</div>
<?php

// Close recordset
if ($chat_grid->Recordset)
	$chat_grid->Recordset->Close();
?>
<?php if ($chat_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($chat_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($chat_grid->TotalRecs == 0 && $chat->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($chat_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($chat->Export == "") { ?>
<script type="text/javascript">
fchatgrid.Init();
</script>
<?php } ?>
<?php
$chat_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$chat_grid->Page_Terminate();
?>
