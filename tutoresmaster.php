<?php

// Dni_Tutor
// Apellidos_Nombres
// Tel_Contacto
// Cuil
// Id_Relacion
// Fecha_Actualizacion
// Usuario

?>
<?php if ($tutores->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tutores->TableCaption() ?></h4> -->
<table id="tbl_tutoresmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $tutores->TableCustomInnerHtml ?>
	<tbody>
<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<tr id="r_Dni_Tutor">
			<td><?php echo $tutores->Dni_Tutor->FldCaption() ?></td>
			<td<?php echo $tutores->Dni_Tutor->CellAttributes() ?>>
<span id="el_tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<?php echo $tutores->Dni_Tutor->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<tr id="r_Apellidos_Nombres">
			<td><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></td>
			<td<?php echo $tutores->Apellidos_Nombres->CellAttributes() ?>>
<span id="el_tutores_Apellidos_Nombres">
<span<?php echo $tutores->Apellidos_Nombres->ViewAttributes() ?>>
<?php echo $tutores->Apellidos_Nombres->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<tr id="r_Tel_Contacto">
			<td><?php echo $tutores->Tel_Contacto->FldCaption() ?></td>
			<td<?php echo $tutores->Tel_Contacto->CellAttributes() ?>>
<span id="el_tutores_Tel_Contacto">
<span<?php echo $tutores->Tel_Contacto->ViewAttributes() ?>>
<?php echo $tutores->Tel_Contacto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<tr id="r_Cuil">
			<td><?php echo $tutores->Cuil->FldCaption() ?></td>
			<td<?php echo $tutores->Cuil->CellAttributes() ?>>
<span id="el_tutores_Cuil">
<span<?php echo $tutores->Cuil->ViewAttributes() ?>>
<?php echo $tutores->Cuil->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<tr id="r_Id_Relacion">
			<td><?php echo $tutores->Id_Relacion->FldCaption() ?></td>
			<td<?php echo $tutores->Id_Relacion->CellAttributes() ?>>
<span id="el_tutores_Id_Relacion">
<span<?php echo $tutores->Id_Relacion->ViewAttributes() ?>>
<?php echo $tutores->Id_Relacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<tr id="r_Fecha_Actualizacion">
			<td><?php echo $tutores->Fecha_Actualizacion->FldCaption() ?></td>
			<td<?php echo $tutores->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_tutores_Fecha_Actualizacion">
<span<?php echo $tutores->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $tutores->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tutores->Usuario->Visible) { // Usuario ?>
		<tr id="r_Usuario">
			<td><?php echo $tutores->Usuario->FldCaption() ?></td>
			<td<?php echo $tutores->Usuario->CellAttributes() ?>>
<span id="el_tutores_Usuario">
<span<?php echo $tutores->Usuario->ViewAttributes() ?>>
<?php echo $tutores->Usuario->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
