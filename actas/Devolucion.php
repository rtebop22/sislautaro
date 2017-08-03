<link rel="stylesheet" type="text/css" href="EstiloActa.css">

<?php 

$action='Generar';
switch ($action)
{
    case 'Generar':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        $serie= $_GET['serie'];
	    break;
    default :
}
?>
<?php
$link = mysqli_connect("localhost", "root", "sistema");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "SELECT devolucion_equipo.NroSerie AS Serie,
  devolucion_equipo.Fecha_Devolucion,
  devolucion_equipo.Observacion,
  devolucion_equipo.Devuelve_Cargador,
  personas.Dni AS Dni,
  personas.Apellidos_Nombres AS NombreTitular,
  tutores.Dni_Tutor AS DniTutor,
  tutores.Apellidos_Nombres AS NombreTutor,
  dato_establecimiento.Nombre_Establecimiento AS Escuela,
  autoridades_escolares.Apellido_Nombre AS Autoridad,
  referente_tecnico.Apellido_Nombre AS Rte,
  cursos.Descripcion AS Curso,
  division.Descripcion AS Division,
  turno.Descripcion AS Turno,
  localidades.Nombre AS Localidad,
  motivo_devolucion.Detalle AS Motivo,
  estado_equipo_devuelto.Detalle AS Estado
FROM devolucion_equipo
  INNER JOIN personas ON devolucion_equipo.Dni = personas.Dni
  INNER JOIN tutores ON devolucion_equipo.Dni_Tutor = tutores.Dni_Tutor
  INNER JOIN autoridades_escolares ON devolucion_equipo.Id_Autoridad =
    autoridades_escolares.Id_Autoridad
  INNER JOIN dato_establecimiento ON autoridades_escolares.Cue =
    dato_establecimiento.Cue
  INNER JOIN referente_tecnico ON devolucion_equipo.Admin_Que_Recibe =
    referente_tecnico.DniRte
  INNER JOIN cursos ON personas.Id_Curso = cursos.Id_Curso
  INNER JOIN division ON personas.Id_Division = division.Id_Division
  INNER JOIN turno ON personas.Id_Turno = turno.Id_Turno
  INNER JOIN localidades ON dato_establecimiento.Id_Localidad =
    localidades.Id_Localidad
  INNER JOIN motivo_devolucion ON devolucion_equipo.Id_Motivo =
    motivo_devolucion.Id_Motivo
  INNER JOIN estado_equipo_devuelto ON devolucion_equipo.Id_Estado_Devol =
    estado_equipo_devuelto.Id_Estado_Devol
WHERE devolucion_equipo.NroSerie = '$serie'");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
$Localidad = $resultado['Localidad'];
$Fecha_Devolucion = $resultado['Fecha_Devolucion'];
$Escuela = $resultado['Escuela'];
$NombreAlumno = $resultado['NombreTitular'];
$DniAlumno = $resultado['Dni'];
$Curso = $resultado['Curso'];
$Division = $resultado['Division'];
$Turno = $resultado['Turno'];
$NombreTutor = $resultado['NombreTutor'];
$DniTutor = $resultado['DniTutor'];
$Autoridad = $resultado['Autoridad'];
$Observacion = $resultado['Observacion'];
$Rte = $resultado['Rte'];
$Motivo = $resultado['Motivo'];
$Cargador = $resultado['Devuelve_Cargador'];
$Estado = $resultado['Estado'];
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
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
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
<p align="center" class="Estilo1">Acta de Devolución </p>
<p class="estiloActa Estilo2"> En la ciudad de....<?php echo $Localidad?>..Provincia de Misiones, siendo la fecha <?php echo $Fecha_Devolucion?>
,el/la Señor/a Director/a de/la ......<?php echo $Escuela?>.., en su caracter de responsable del "Programa ConectarIgualdad.com.ar" 
de este Establecimiento y el Referente Tecnico, Reciben de parte del padre/tutor la netbook entregada al alumno/a........<?php echo $NombreAlumno?>........DNI......<?php echo $DniAlumno?>.....del..Año:."<?php echo $Curso?>°...Div.:....<?php echo $Division?>.."...,Turno......<?php echo $Turno?>......Padre/Tutor..........<?php echo $NombreTutor?>......DNI:.........<?php echo $DniTutor?>....
<p class="estiloActa Estilo2">

<p align="center" class="Estilo2">Padre/Tutor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director/a
  <p align="center" class="Estilo2">
  
  <p align="center" class="Estilo2">
  
  <p class="estiloActa Estilo2">Seguidamente y a fines de cumplimentar con la medida adoptada,se procede a hacer entrega en el Establecimiento.....<?php echo $Escuela?>....,Al Rte:..<?php echo $Rte?>..., de UNA COMPUTADORA (NETBOOK),Serie Nro.:.<?php echo $serie?>.., por motivo:.....<?php echo $Motivo?>..... recibiéndola.:.<?php echo $Estado?>.......,con cargador?:.....<?php echo $Cargador?>...         
    OBSERVACIONES:..........<?php echo $Observacion?>.....&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <p></p>
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