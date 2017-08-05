<?php

// Usuario_1
// Usuario_2
// Fecha_Hora

?>
<?php if ($conversaciones->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $conversaciones->TableCaption() ?></h4> -->
<table id="tbl_conversacionesmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $conversaciones->TableCustomInnerHtml ?>
	<tbody>
<?php if ($conversaciones->Usuario_1->Visible) { // Usuario_1 ?>
		<tr id="r_Usuario_1">
			<td><?php echo $conversaciones->Usuario_1->FldCaption() ?></td>
			<td<?php echo $conversaciones->Usuario_1->CellAttributes() ?>>
<span id="el_conversaciones_Usuario_1">
<span<?php echo $conversaciones->Usuario_1->ViewAttributes() ?>>
<?php echo $conversaciones->Usuario_1->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($conversaciones->Usuario_2->Visible) { // Usuario_2 ?>
		<tr id="r_Usuario_2">
			<td><?php echo $conversaciones->Usuario_2->FldCaption() ?></td>
			<td<?php echo $conversaciones->Usuario_2->CellAttributes() ?>>
<span id="el_conversaciones_Usuario_2">
<span<?php echo $conversaciones->Usuario_2->ViewAttributes() ?>>
<?php echo $conversaciones->Usuario_2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($conversaciones->Fecha_Hora->Visible) { // Fecha_Hora ?>
		<tr id="r_Fecha_Hora">
			<td><?php echo $conversaciones->Fecha_Hora->FldCaption() ?></td>
			<td<?php echo $conversaciones->Fecha_Hora->CellAttributes() ?>>
<span id="el_conversaciones_Fecha_Hora">
<span<?php echo $conversaciones->Fecha_Hora->ViewAttributes() ?>>
<?php echo $conversaciones->Fecha_Hora->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
