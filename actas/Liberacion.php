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
$consulta = mysqli_query($link, "SELECT liberacion_equipo.Dni AS Dni,
  liberacion_equipo.NroSerie AS NroSerie,
  personas.Apellidos_Nombres AS Apellidos_Nombres,
  tutores.Apellidos_Nombres AS NombreTutor,
  liberacion_equipo.Dni_Tutor AS Dni_Tutor,
  liberacion_equipo.Fecha_Finalizacion AS Fecha_Finalizacion,
  liberacion_equipo.Fecha_Liberacion AS Fecha_Liberacion,
  liberacion_equipo.Observacion AS Observacion,
  autoridades_escolares.Apellido_Nombre AS Autoridad,
  nivel_educativo.Detalle AS Nivel,
  modalidad_establecimiento.Nombre AS Modalidad,
  dato_establecimiento.Nombre_Establecimiento AS Escuela,
  localidades.Nombre AS Localidad,
  cursos.Descripcion AS Curso,
  division.Descripcion AS Divis,
  turno.Descripcion AS Turno
FROM (liberacion_equipo
  JOIN personas ON liberacion_equipo.Dni = personas.Dni)
  JOIN tutores ON liberacion_equipo.Dni_Tutor = tutores.Dni_Tutor
  INNER JOIN autoridades_escolares ON liberacion_equipo.Id_Autoridad =
    autoridades_escolares.Id_Autoridad
  INNER JOIN nivel_educativo ON liberacion_equipo.Id_Nivel =
    nivel_educativo.Id_Nivel
  INNER JOIN modalidad_establecimiento ON liberacion_equipo.Id_Modalidad =
    modalidad_establecimiento.Id_Modalidad
  INNER JOIN dato_establecimiento ON autoridades_escolares.Cue =
    dato_establecimiento.Cue
  INNER JOIN localidades ON dato_establecimiento.Id_Localidad =
    localidades.Id_Localidad
  INNER JOIN cursos ON personas.Id_Curso = cursos.Id_Curso
  INNER JOIN division ON personas.Id_Division = division.Id_Division
  INNER JOIN turno ON personas.Id_Turno = turno.Id_Turno
WHERE (liberacion_equipo.NroSerie='$serie')");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
$Fecha_Liberacion = $resultado['Fecha_Liberacion'];
$Localidad = $resultado['Localidad'];
$Fecha_Finalizacion=$resultado['Fecha_Finalizacion'];
$NombreAlumno = $resultado['Apellidos_Nombres'];
$DniAlumno = $resultado['Dni'];
$NombreTutor = $resultado['NombreTutor'];
$DniTutor = $resultado['Dni_Tutor'];
$Curso = $resultado['Curso'];
$Division = $resultado['Divis'];
$Turno = $resultado['Turno'];
$Autoridad = $resultado['Autoridad'];
$Nivel = $resultado['Nivel'];
$Modalidad = $resultado['Modalidad'];
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
<p align="center" class="Estilo1">Acta de Liberación </p>
<p class="estiloActa Estilo2">En la Ciudad de ...<?php echo $Localidad?>...,Provincia de Misiones, siendo la fecha <?php echo $Fecha_Liberacion?>...
  el/la Sr/Sra Director/a de el/la....<?php echo $Escuela?>..., en su carácter de comodante
  y maximo responsable del "ProgramaConectarIgualdad.com.ar" de este Establecimiento
  y el Sr/a....<?php echo $NombreTutor?>.. DNI...<?php echo $DniTutor?>.... 
  Padre/tutor de/la Alumno/a <?php echo $NombreAlumno?>...
  del..curso <?php echo $Curso?>°.division ."<?php echo $Division?>"..Turno..<?php echo $Turno?>...,Modalidad..<?php echo $Modalidad?>...,
  quien ha finalizado y completado sus estudios de nivel..<?php echo $Nivel?>..
  el día..<?php echo $Fecha_Finalizacion?>...,procede a notificarle de conformidad a lo estipulado 
  en la cláusala cuarta del contrato de comodato oportunamente celebrado,
  que reza "CUARTA: El Presente contrato tendra vigencia desde la firma del mismo
  hasta el momente en el que el estudiante dé por acreditado con titulo la finalización
  de su paso a través del sistema de educación secundaria. 
  Una vez que esto se realice, la netbook pasará a ser propiedad del estudiante",
  que la netbook que se le hiciera entrega en comodato a partir de la fecha queda liberada
  y pasa a ser propiedad del alumno antes citado. 
  Firmando los intervinientes al pié en prueba de conformidad.----
  Seguidamente y a fines de cumplimentar con la medida adoptada,
  se procede a hacer entrega al/la alumno/a..:...,...<?php echo $NombreAlumno?>.....
  DNI No...<?php echo $DniAlumno?>...,de UNA COMPUTADORA NETBOOK.
  Serie No.:....<?php echo $serie?>.., recibiéndola de conformidad liberada y en el estado en que se encuentra,
  pasando a ser desde este momento de su legítima propiedad.
  No siendo para más se da por finalizado el acto, firmando al pié de conformidad y para constancia,
  el alumno/a, y su padre/tutor ante mi........<?php echo $Autoridad?>.............,Director/a del Establecimiento.
OBSERVACIONES:.....<?php echo $Observacion?>......</p>

  <p align="center" class="Estilo2">..........................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;............................&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ....................... </p>
  <p align="center"><span class="Estilo2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Alumno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tutor/a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Directivo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;</p>

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