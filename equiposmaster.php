<?php

// NroSerie
// NroMac
// Id_Ubicacion
// Id_Estado
// Id_Sit_Estado
// Id_Marca
// Id_Modelo
// Id_Ano
// Id_Tipo_Equipo
// Usuario
// Fecha_Actualizacion

?>
<?php if ($equipos->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $equipos->TableCaption() ?></h4> -->
<table id="tbl_equiposmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $equipos->TableCustomInnerHtml ?>
	<tbody>
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<tr id="r_NroSerie">
			<td><?php echo $equipos->NroSerie->FldCaption() ?></td>
			<td<?php echo $equipos->NroSerie->CellAttributes() ?>>
<span id="el_equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<?php echo $equipos->NroSerie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<tr id="r_NroMac">
			<td><?php echo $equipos->NroMac->FldCaption() ?></td>
			<td<?php echo $equipos->NroMac->CellAttributes() ?>>
<span id="el_equipos_NroMac">
<span<?php echo $equipos->NroMac->ViewAttributes() ?>>
<?php echo $equipos->NroMac->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<tr id="r_Id_Ubicacion">
			<td><?php echo $equipos->Id_Ubicacion->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<span id="el_equipos_Id_Ubicacion">
<span<?php echo $equipos->Id_Ubicacion->ViewAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<tr id="r_Id_Estado">
			<td><?php echo $equipos->Id_Estado->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Estado">
<span<?php echo $equipos->Id_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<tr id="r_Id_Sit_Estado">
			<td><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Sit_Estado">
<span<?php echo $equipos->Id_Sit_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<tr id="r_Id_Marca">
			<td><?php echo $equipos->Id_Marca->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<span id="el_equipos_Id_Marca">
<span<?php echo $equipos->Id_Marca->ViewAttributes() ?>>
<?php echo $equipos->Id_Marca->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<tr id="r_Id_Modelo">
			<td><?php echo $equipos->Id_Modelo->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<span id="el_equipos_Id_Modelo">
<span<?php echo $equipos->Id_Modelo->ViewAttributes() ?>>
<?php echo $equipos->Id_Modelo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<tr id="r_Id_Ano">
			<td><?php echo $equipos->Id_Ano->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<span id="el_equipos_Id_Ano">
<span<?php echo $equipos->Id_Ano->ViewAttributes() ?>>
<?php echo $equipos->Id_Ano->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<tr id="r_Id_Tipo_Equipo">
			<td><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></td>
			<td<?php echo $equipos->Id_Tipo_Equipo->CellAttributes() ?>>
<span id="el_equipos_Id_Tipo_Equipo">
<span<?php echo $equipos->Id_Tipo_Equipo->ViewAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<tr id="r_Usuario">
			<td><?php echo $equipos->Usuario->FldCaption() ?></td>
			<td<?php echo $equipos->Usuario->CellAttributes() ?>>
<span id="el_equipos_Usuario">
<span<?php echo $equipos->Usuario->ViewAttributes() ?>>
<?php echo $equipos->Usuario->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<tr id="r_Fecha_Actualizacion">
			<td><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></td>
			<td<?php echo $equipos->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_equipos_Fecha_Actualizacion">
<span<?php echo $equipos->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $equipos->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
