<?php

// Cue
// Nombre_Establecimiento
// Id_Departamento
// Id_Localidad
// Domicilio
// Telefono_Escuela
// Mail_Escuela
// Matricula_Actual
// Usuario
// Fecha_Actualizacion

?>
<?php if ($dato_establecimiento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $dato_establecimiento->TableCaption() ?></h4> -->
<table id="tbl_dato_establecimientomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $dato_establecimiento->TableCustomInnerHtml ?>
	<tbody>
<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
		<tr id="r_Cue">
			<td><?php echo $dato_establecimiento->Cue->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Cue->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cue">
<span<?php echo $dato_establecimiento->Cue->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cue->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<tr id="r_Nombre_Establecimiento">
			<td><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Nombre_Establecimiento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nombre_Establecimiento">
<span<?php echo $dato_establecimiento->Nombre_Establecimiento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nombre_Establecimiento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
		<tr id="r_Id_Departamento">
			<td><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Departamento">
<span<?php echo $dato_establecimiento->Id_Departamento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
		<tr id="r_Id_Localidad">
			<td><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Localidad">
<span<?php echo $dato_establecimiento->Id_Localidad->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
		<tr id="r_Domicilio">
			<td><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Domicilio->CellAttributes() ?>>
<span id="el_dato_establecimiento_Domicilio">
<span<?php echo $dato_establecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Domicilio->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
		<tr id="r_Telefono_Escuela">
			<td><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Telefono_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Telefono_Escuela">
<span<?php echo $dato_establecimiento->Telefono_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Telefono_Escuela->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
		<tr id="r_Mail_Escuela">
			<td><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Mail_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Mail_Escuela">
<span<?php echo $dato_establecimiento->Mail_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Mail_Escuela->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
		<tr id="r_Matricula_Actual">
			<td><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Matricula_Actual->CellAttributes() ?>>
<span id="el_dato_establecimiento_Matricula_Actual">
<span<?php echo $dato_establecimiento->Matricula_Actual->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Matricula_Actual->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
		<tr id="r_Usuario">
			<td><?php echo $dato_establecimiento->Usuario->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Usuario->CellAttributes() ?>>
<span id="el_dato_establecimiento_Usuario">
<span<?php echo $dato_establecimiento->Usuario->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Usuario->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<tr id="r_Fecha_Actualizacion">
			<td><?php echo $dato_establecimiento->Fecha_Actualizacion->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_dato_establecimiento_Fecha_Actualizacion">
<span<?php echo $dato_establecimiento->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
