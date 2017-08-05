<link rel="stylesheet" type="text/css" href="EstiloActa.css">

<?php 

$action='Generar';
switch ($action)
{
    case 'Generar':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        $IdPase= $_GET['Id_Pase'];
	    break;
    default :
}
?>
<?php
$link = mysqli_connect("localhost", "root", "sistema");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "SELECT pase_establecimiento.Id_Pase,
  pase_establecimiento.Serie_Equipo,
  pase_establecimiento.Fecha_Pase,
  pase_establecimiento.Id_Hardware,
  pase_establecimiento.SN,
  pase_establecimiento.Modelo_Net,
  pase_establecimiento.Nombre_Titular,
  pase_establecimiento.Dni_Titular,
  pase_establecimiento.Cuil_Titular,
  pase_establecimiento.DniTutor,
  pase_establecimiento.Nombre_Tutor,
  pase_establecimiento.Cue_Establecimiento_Alta,
  pase_establecimiento.Escuela_Alta,
  pase_establecimiento.Directivo_Alta,
  pase_establecimiento.Cuil_Directivo_Alta,
  pase_establecimiento.Domicilio_Esc_Alta,
  pase_establecimiento.Cue_Establecimiento_Baja,
  pase_establecimiento.Escuela_Baja,
  pase_establecimiento.Directivo_Baja,
  pase_establecimiento.Cuil_Directivo_Baja,
  pase_establecimiento.Domicilio_Esc_Baja,
  pase_establecimiento.Dpto_Esc_alta,
  pase_establecimiento.Localidad_Esc_Alta,
  pase_establecimiento.Dpto_Esc_Baja,
  pase_establecimiento.Localidad_Esc_Baja,
  pase_establecimiento.Rte_Baja,
  pase_establecimiento.Tel_Rte_Baja,
  pase_establecimiento.Email_Rte_Baja,
  pase_establecimiento.Serie_Server_Baja,
  pase_establecimiento.Rte_Alta,
  pase_establecimiento.Tel_Rte_Alta,
  pase_establecimiento.Email_Rte_Alta,
  pase_establecimiento.Serie_Server_Alta,
  pase_establecimiento.CelTutor,
  pase_establecimiento.Tel_Tutor,
  pase_establecimiento.Domicilio
FROM pase_establecimiento
WHERE pase_establecimiento.Id_Pase = $IdPase");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
$Serie_Equipo = $resultado['Serie_Equipo'];
$Fecha_Pase = $resultado['Fecha_Pase'];
$Id_Hardware=$resultado['Id_Hardware'];
$SN = $resultado['SN'];
$Modelo_Net = $resultado['Modelo_Net'];
$Nombre_Titular = $resultado['Nombre_Titular'];
$Dni_Titular = $resultado['Dni_Titular'];
$Cuil_Titular = $resultado['Cuil_Titular'];
$DniTutor = $resultado['DniTutor'];
$Nombre_Tutor = $resultado['Nombre_Tutor'];
$Cue_Establecimiento_Alta = $resultado['Cue_Establecimiento_Alta'];
$Escuela_Alta = $resultado['Escuela_Alta'];
$Directivo_Alta = $resultado['Directivo_Alta'];
$Cuil_Directivo_Alta = $resultado['Cuil_Directivo_Alta'];
$Domicilio_Esc_Alta = $resultado['Domicilio_Esc_Alta'];
$Cue_Establecimiento_Baja = $resultado['Cue_Establecimiento_Baja'];
$Escuela_Baja = $resultado['Escuela_Baja'];
$Directivo_Baja = $resultado['Directivo_Baja'];
$Cuil_Directivo_Baja = $resultado['Cuil_Directivo_Baja'];
$Domicilio_Esc_Baja = $resultado['Domicilio_Esc_Baja'];
$Dpto_Esc_alta = $resultado['Dpto_Esc_alta'];
$Localidad_Esc_Alta = $resultado['Localidad_Esc_Alta'];
$Dpto_Esc_Baja = $resultado['Dpto_Esc_Baja'];
$Localidad_Esc_Baja = $resultado['Localidad_Esc_Baja'];
$Rte_Baja = $resultado['Rte_Baja'];
$Tel_Rte_Baja = $resultado['Tel_Rte_Baja'];
$Email_Rte_Baja = $resultado['Email_Rte_Baja'];
$Serie_Server_Baja = $resultado['Serie_Server_Baja'];
$Rte_Alta = $resultado['Rte_Alta'];
$Tel_Rte_Alta = $resultado['Tel_Rte_Alta'];
$Email_Rte_Alta = $resultado['Email_Rte_Alta'];
$Serie_Server_Alta = $resultado['Serie_Server_Alta'];
$CelTutor = $resultado['CelTutor'];
$Tel_Tutor = $resultado['Tel_Tutor'];
$DomicilioTutor = $resultado['Domicilio'];
//echo $Direccion = $resultado['Domicilio'];
//}else{
//echo "No hay Resultados";
//}
mysqli_free_result($consulta);
mysqli_close($link);
?>
<link href="EstiloActa.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {font-size: 16px}
.Estilo4 {
	font-weight: bold;
	color: #0000CC;
	background-color: #CC99FF;
	border: thin solid #CCFF33;
	font-family: Arial, Helvetica, sans-serif;
	cursor: crosshair;
	filter: Light;
}
.Estilo5 {font-size: 18px}
-->
</style>

<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<div id="muestra">
 <div>
   <div align="center">
     <p><img src="pase.png" width="246" height="70" /></p>
    </div>
 </div>
  <table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><table width="100%" border="2" cellspacing="1" cellpadding="1">
	  <tr>
        <th scope="col"><div align="left" class="Estilo5">ALUMNO/A</div></th>
      </tr>
    </table>
	<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Apellidos y Nombres </div></th>
    <th width="35%" scope="col"><div align="center"><?php echo $Nombre_Titular?></div></th>
    <th width="19%" scope="col"><div align="right">Cuil</div></th>
    <th width="25%" scope="col"><div align="center"><?php echo $Cuil_Titular?></div></th>
  </tr>
</table>
<table width="100%" border="2" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><div align="left" class="Estilo5">TUTOR/A</div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Apellidos y Nombres </div></th>
    <th width="35%" scope="col"><div align="center"><?php echo $Nombre_Tutor?></div></th>
    <th width="19%" scope="col"><div align="right">Dni</div></th>
    <th width="25%" scope="col"><div align="center"><?php echo $DniTutor?></div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Domicilio</div></th>
    <th width="79%" scope="col"><?php echo $DomicilioTutor?></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Localidad</div></th>
    <th width="35%" scope="col"><div align="center">___________________</div></th>
    <th width="19%" scope="col"><div align="right">Provincia</div></th>
    <th width="25%" scope="col"><div align="center">MISIONES</div></th>
  </tr>
  <tr>
    <th scope="row"><div align="right">Telefono</div></th>
    <td><div align="center"><strong><?php echo $Tel_Tutor?></strong></div></td>
    <td><div align="right"><strong>Celular</strong></div></td>
    <td><div align="center"><strong><?php echo $CelTutor?></strong></div></td>
  </tr>
</table>
<table width="100%" border="2" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><div align="left" class="Estilo5">NETBOOK A TRANSFERIR </div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Nro de Serie </div></th>
    <th width="35%" scope="col"><div align="center"><?php echo $Serie_Equipo?></div></th>
    <th width="19%" scope="col"><div align="right">Id Hardware </div></th>
    <th width="25%" scope="col"><div align="center"><?php echo $Id_Hardware?></div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">Special Number (S/N) </div></th>
    <th width="79%" scope="col"><div align="center"><?php echo $SN?></div></th>
  </tr>
</table>
<table width="100%" border="2" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><div align="left" class="Estilo5">INSTITUCI&Oacute;N RESPONSABLE DE LA BAJA </div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">ESTABLECIMIENTO</div></th>
    <th width="35%" scope="col"><div align="center"><?php echo $Escuela_Baja?></div></th>
    <th width="19%" scope="col"><div align="right">CUE</div></th>
    <th width="25%" scope="col"><div align="center"><?php echo $Cue_Establecimiento_Baja?></div></th>
  </tr>
  <tr>
    <th scope="row"><div align="right">DIRECTOR/A</div></th>
    <td><div align="center"><strong><?php echo $Directivo_Baja?></strong></div></td>
    <td><div align="right"><strong>CUIL</strong></div></td>
    <td><div align="center"><strong><?php echo $Cuil_Directivo_Baja?></strong></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="right">RTE</div></th>
    <td><div align="center"><strong><?php echo $Rte_Baja?></strong></div></td>
    <td><div align="right"><strong>TELEFONO</strong></div></td>
    <td><div align="center"><strong><?php echo $Tel_Rte_Baja?></strong></div></td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">N&deg; Serie Servidor </div></th>
    <th width="79%" scope="col"><div align="center"><?php echo $Serie_Server_Baja?></div></th>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="33%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma RTE </p></th>
    <th width="31%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma Tutor/a </p></th>
    <th width="36%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma Director/a </p></th>
  </tr>
</table>
<table width="100%" border="2" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><div align="left" class="Estilo5">INSTITUCI&Oacute;N RESPONSABLE DEL ALTA </div></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">ESTABLECIMIENTO</div></th>
    <th width="35%" scope="col"><div align="center"><strong><?php echo $Escuela_Alta?></strong></div></th>
    <th width="19%" scope="col"><div align="right">CUE</div></th>
    <th width="25%" scope="col"><div align="center"><strong><?php echo $Cue_Establecimiento_Alta?></strong></div></th>
  </tr>
  <tr>
    <th scope="row"><div align="right">DIRECTOR/A</div></th>
    <td><div align="center"><strong><?php echo $Directivo_Alta?></strong></div></td>
    <td><div align="right"><strong>CUIL</strong></div></td>
    <td><div align="center"><strong><?php echo $Cuil_Directivo_Alta?></strong></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="right">RTE</div></th>
    <td><div align="center"><strong><?php echo $Rte_Alta?></strong></div></td>
    <td><div align="right"><strong>TELEFONO</strong></div></td>
    <td><div align="center"><strong><?php echo $Tel_Rte_Alta?></strong></div></td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th width="21%" scope="col"><div align="right">N&deg; Serie Servidor </div></th>
    <th width="79%" scope="col"><div align="center"><?php echo $Serie_Server_Alta?></div></th>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="33%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma RTE </p></th>
    <th width="31%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma Tutor/a </p></th>
    <th width="36%" scope="col"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Firma Director/a </p></th>
  </tr>
</table>

</th>
  </tr>
</table>


</p>
</div>
<div>
<p align="center" class="estiloActa Estilo3">
  <input name="IMPRIMIR EL ACTA" type="button" class="Estilo4"  onclick="printDiv('muestra')"
value="Imprimir"/>
  &nbsp;
  <input name="button" type="button" class="Estilo4" onclick="history.back(-1)" value="Volver" />
</div>
</p>
</div>