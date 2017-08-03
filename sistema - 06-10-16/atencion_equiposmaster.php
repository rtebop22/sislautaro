<?php

// Id_Atencion
// Dni
// NroSerie
// Fecha_Entrada
// Id_Prioridad
// Usuario

?>
<?php if ($atencion_equipos->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $atencion_equipos->TableCaption() ?></h4> -->
<table id="tbl_atencion_equiposmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $atencion_equipos->TableCustomInnerHtml ?>
	<tbody>
<?php if ($atencion_equipos->Id_Atencion->Visible) { // Id_Atencion ?>
		<tr id="r_Id_Atencion">
			<td><?php echo $atencion_equipos->Id_Atencion->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->Id_Atencion->CellAttributes() ?>>
<span id="el_atencion_equipos_Id_Atencion">
<span<?php echo $atencion_equipos->Id_Atencion->ViewAttributes() ?>>
<?php echo $atencion_equipos->Id_Atencion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($atencion_equipos->Dni->Visible) { // Dni ?>
		<tr id="r_Dni">
			<td><?php echo $atencion_equipos->Dni->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->Dni->CellAttributes() ?>>
<span id="el_atencion_equipos_Dni">
<span<?php echo $atencion_equipos->Dni->ViewAttributes() ?>>
<?php echo $atencion_equipos->Dni->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($atencion_equipos->NroSerie->Visible) { // NroSerie ?>
		<tr id="r_NroSerie">
			<td><?php echo $atencion_equipos->NroSerie->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->NroSerie->CellAttributes() ?>>
<span id="el_atencion_equipos_NroSerie">
<span<?php echo $atencion_equipos->NroSerie->ViewAttributes() ?>>
<?php echo $atencion_equipos->NroSerie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($atencion_equipos->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
		<tr id="r_Fecha_Entrada">
			<td><?php echo $atencion_equipos->Fecha_Entrada->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->Fecha_Entrada->CellAttributes() ?>>
<span id="el_atencion_equipos_Fecha_Entrada">
<span<?php echo $atencion_equipos->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $atencion_equipos->Fecha_Entrada->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($atencion_equipos->Id_Prioridad->Visible) { // Id_Prioridad ?>
		<tr id="r_Id_Prioridad">
			<td><?php echo $atencion_equipos->Id_Prioridad->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->Id_Prioridad->CellAttributes() ?>>
<span id="el_atencion_equipos_Id_Prioridad">
<span<?php echo $atencion_equipos->Id_Prioridad->ViewAttributes() ?>>
<?php echo $atencion_equipos->Id_Prioridad->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($atencion_equipos->Usuario->Visible) { // Usuario ?>
		<tr id="r_Usuario">
			<td><?php echo $atencion_equipos->Usuario->FldCaption() ?></td>
			<td<?php echo $atencion_equipos->Usuario->CellAttributes() ?>>
<span id="el_atencion_equipos_Usuario">
<span<?php echo $atencion_equipos->Usuario->ViewAttributes() ?>>
<?php echo $atencion_equipos->Usuario->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
