<?php

// Id_Atencion
// Id_Tipo_Falla
// Id_Problema
// Descripcion_Problema
// Id_Tipo_Sol_Problem
// Id_Estado_Atenc
// Fecha_Actualizacion

?>
<?php if ($detalle_atencion->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $detalle_atencion->TableCaption() ?></h4> -->
<table id="tbl_detalle_atencionmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $detalle_atencion->TableCustomInnerHtml ?>
	<tbody>
<?php if ($detalle_atencion->Id_Atencion->Visible) { // Id_Atencion ?>
		<tr id="r_Id_Atencion">
			<td><?php echo $detalle_atencion->Id_Atencion->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Id_Atencion->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Atencion">
<span<?php echo $detalle_atencion->Id_Atencion->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Atencion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
		<tr id="r_Id_Tipo_Falla">
			<td><?php echo $detalle_atencion->Id_Tipo_Falla->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Id_Tipo_Falla->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Tipo_Falla">
<span<?php echo $detalle_atencion->Id_Tipo_Falla->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
		<tr id="r_Id_Problema">
			<td><?php echo $detalle_atencion->Id_Problema->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Id_Problema->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Problema">
<span<?php echo $detalle_atencion->Id_Problema->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
		<tr id="r_Descripcion_Problema">
			<td><?php echo $detalle_atencion->Descripcion_Problema->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Descripcion_Problema->CellAttributes() ?>>
<span id="el_detalle_atencion_Descripcion_Problema">
<span<?php echo $detalle_atencion->Descripcion_Problema->ViewAttributes() ?>>
<?php echo $detalle_atencion->Descripcion_Problema->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
		<tr id="r_Id_Tipo_Sol_Problem">
			<td><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Tipo_Sol_Problem">
<span<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
		<tr id="r_Id_Estado_Atenc">
			<td><?php echo $detalle_atencion->Id_Estado_Atenc->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Id_Estado_Atenc->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Estado_Atenc">
<span<?php echo $detalle_atencion->Id_Estado_Atenc->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($detalle_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<tr id="r_Fecha_Actualizacion">
			<td><?php echo $detalle_atencion->Fecha_Actualizacion->FldCaption() ?></td>
			<td<?php echo $detalle_atencion->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_detalle_atencion_Fecha_Actualizacion">
<span<?php echo $detalle_atencion->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $detalle_atencion->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
