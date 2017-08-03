<?php

// NroSerie
// Id_Ubicacion
// Id_Estado
// Id_Sit_Estado

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
	</tbody>
</table>
<?php } ?>
