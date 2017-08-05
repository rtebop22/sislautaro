<link rel="stylesheet" type="text/css" href="EstiloActa.css">

<?php 

$action='Generar';
switch ($action)
{
    case 'Generar':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        $IdPrestamo= $_GET['IdPrestamo'];
	    break;
    default :
}
?>
<?php
$link = mysqli_connect("localhost", "root", "sistema");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "SELECT prestamo_equipo.Id_Prestamo AS Id_Prestamo,
  personas.Dni AS Dni,
  personas.Apellidos_Nombres AS Nombre_Titular,
  prestamo_equipo.NroSerie AS Nro_Serie,
  motivo_prestamo_equipo.Descripcion AS Motivo,
  prestamo_equipo.Fecha_Prestamo AS Fecha,
  prestamo_equipo.Observacion AS Observacion,
  prestamo_equipo.Prestamo_Cargador AS Cargador,
  estado_prestamo_equipo.Descripcion AS Estado,
  prestamo_equipo.Usuario AS Usuario,
  dato_establecimiento.Nombre_Establecimiento AS Escuela,
  localidades.Nombre AS Localidad
FROM prestamo_equipo
  INNER JOIN personas ON prestamo_equipo.Dni = personas.Dni
  INNER JOIN motivo_prestamo_equipo ON prestamo_equipo.Id_Motivo_Prestamo =
    motivo_prestamo_equipo.Id_Motivo_Prestamo
  INNER JOIN estado_prestamo_equipo ON prestamo_equipo.Id_Estado_Prestamo =
    estado_prestamo_equipo.Id_Estado_Prestamo,
  dato_establecimiento
  INNER JOIN localidades ON dato_establecimiento.Id_Localidad =
    localidades.Id_Localidad
WHERE prestamo_equipo.Id_Prestamo = $IdPrestamo");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
$Fecha_Prestamo = $resultado['Fecha'];
$Localidad = $resultado['Localidad'];
$NombreAlumno = $resultado['Nombre_Titular'];
$Dni = $resultado['Dni'];
$Motivo = $resultado['Motivo'];
$Cargador = $resultado['Cargador'];
$Rte = $resultado['Usuario'];
$Serie = $resultado['Nro_Serie'];
$Escuela = $resultado['Escuela'];
$Observacion = $resultado['Observacion'];
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
.Estilo2 {font-size: 18}
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
.Estilo5 {
	font-size: 18;
	font-weight: bold;
}
.Estilo6 {font-size: 24px; font-weight: bold; }
.Estilo8 {font-size: 12}
.Estilo10 {font-size: 12; font-weight: bold; }
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
   <table width="99%" border="2" cellpadding="1" cellspacing="1" margin-right: 10%>
    <tr>
      <th width="7%" scope="col"><div align="center">Original</div></th>
      <th width="93%" bordercolor="#000000" scope="col"><div class="borde">
          <div align="left" style="border:#000000 thin solid" >Prestamo Nro: <?php echo $IdPrestamo?></div>
           <p align="center" class="Estilo6">Constancia de Prestamo </p>
        <p align="justify" class="estiloActa">En la localidad de <?php echo $Localidad?> a la fecha <?php echo $Fecha_Prestamo?>, El Rte:"<?php echo $Rte?>"  deja constancia que el Alumno/a: <?php echo $NombreAlumno?> , Dni: <?php echo $Dni?> del <?php echo $Escuela?>, retira el equipo con Serie Nro: "<?php echo $Serie?>" en caracter de &quot;PRESTAMO ESCOLAR&quot; para usos educativos, ya que su equipo original que se le fue entregado por parte del programa Conectar Igualdad no se encuentra disponible por motivo de: "<?php echo $Motivo?>" . El alumno/a se compromete a devolver el equipo una vez que su equipo original este disponible para retiro, en las mismas condiciones en que se le fuese entregado, haciendose responsable por los da&ntilde;os que presente el mismo a la hora de la devoluci&oacute;n.<br />
            <br />
          <span class="Estilo5">* Prestamos con cargador: "<?php echo $Cargador?>"<br />
                * Observaciones: "<?php echo $Observacion?>"</span> <br /><br />
                <span class="Estilo8">&nbsp;&nbsp;&nbsp;&nbsp;...............................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...............................<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alumno/a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RTE </span></p></th>
    </tr>
    <tr>
      <th height="446" scope="row">Duplicado</th>
      <td><div class="borde">
          <div align="left" style="border:#000000 thin solid" >Prestamo Nro: <?php echo $IdPrestamo?></div>
      </div>
        <p align="center" class="Estilo6">Constancia de Prestamo </p>
        <p align="justify" class="estiloActa"><strong>En la localidad de <?php echo $Localidad?> a la fecha <?php echo $Fecha_Prestamo?>, El Rte:&quot;<?php echo $Rte?>&quot;  deja constancia que el Alumno/a: <?php echo $NombreAlumno?> , Dni: <?php echo $Dni?> del <?php echo $Escuela?>, retira el equipo con Serie Nro: &quot;<?php echo $Serie?>&quot; en caracter de &quot;PRESTAMO ESCOLAR&quot; para usos educativos, ya que su equipo original que se le fue entregado por parte del programa Conectar Igualdad no se encuentra disponible por motivo de: &quot;<?php echo $Motivo?>&quot; . El alumno/a se compromete a devolver el equipo una vez que su equipo original este disponible para retiro, en las mismas condiciones en que se le fuese entregado, haciendose responsable por los da&ntilde;os que presente el mismo a la hora de la devoluci&oacute;n.</strong><br />
              <br />
              <span class="Estilo5">* Prestamos con cargador: &quot;<?php echo $Cargador?>&quot;<br />
                * Observaciones: &quot;<?php echo $Observacion?>&quot;</span> <br />
                <br />
&nbsp;&nbsp; .<span class="Estilo10">..............................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...............................<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;Alumno/a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RTE</span></p>
				
      </td>
    </tr>
  </table>
  </p>
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