<?php

// Cue
// Nombre_Establecimiento
// Sigla
// Nro_Cuise
// Id_Departamento
// Id_Localidad
// Cantidad_Aulas
// Cantidad_Turnos
// Id_Tipo_Esc
// Universo
// Sector
// Cantidad_Netbook_Actuales
// Id_Estado_Esc
// Id_Zona
// Fecha_Actualizacion
// Usuario

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
<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
		<tr id="r_Sigla">
			<td><?php echo $dato_establecimiento->Sigla->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Sigla->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sigla">
<span<?php echo $dato_establecimiento->Sigla->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sigla->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
		<tr id="r_Nro_Cuise">
			<td><?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Nro_Cuise->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nro_Cuise">
<span<?php echo $dato_establecimiento->Nro_Cuise->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nro_Cuise->ListViewValue() ?></span>
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
<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
		<tr id="r_Cantidad_Aulas">
			<td><?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Cantidad_Aulas->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Aulas">
<span<?php echo $dato_establecimiento->Cantidad_Aulas->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Aulas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
		<tr id="r_Cantidad_Turnos">
			<td><?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Cantidad_Turnos->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Turnos">
<span<?php echo $dato_establecimiento->Cantidad_Turnos->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Turnos->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
		<tr id="r_Id_Tipo_Esc">
			<td><?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Tipo_Esc">
<span<?php echo $dato_establecimiento->Id_Tipo_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Tipo_Esc->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
		<tr id="r_Universo">
			<td><?php echo $dato_establecimiento->Universo->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Universo->CellAttributes() ?>>
<span id="el_dato_establecimiento_Universo">
<span<?php echo $dato_establecimiento->Universo->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Universo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
		<tr id="r_Sector">
			<td><?php echo $dato_establecimiento->Sector->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Sector->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sector">
<span<?php echo $dato_establecimiento->Sector->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sector->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
		<tr id="r_Cantidad_Netbook_Actuales">
			<td><?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Netbook_Actuales">
<span<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
		<tr id="r_Id_Estado_Esc">
			<td><?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Id_Estado_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Estado_Esc">
<span<?php echo $dato_establecimiento->Id_Estado_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
		<tr id="r_Id_Zona">
			<td><?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></td>
			<td<?php echo $dato_establecimiento->Id_Zona->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Zona">
<span<?php echo $dato_establecimiento->Id_Zona->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->ListViewValue() ?></span>
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
	</tbody>
</table>
<?php } ?>
