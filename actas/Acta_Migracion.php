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
$SerieEquipo = $resultado['Serie_Equipo'];
$Fecha_Pase = $resultado['Fecha_Pase'];
$Id_Hardware = $resultado['Id_Hardware'];
$SN = $resultado['SN'];
$Modelo_Net = $resultado['Modelo_Net'];
$Nombre_Titular = $resultado['Nombre_Titular'];
$Dni_Titular = $resultado['Dni_Titular'];
$Cuil_Titular = $resultado['Cuil_Titular'];
$Cuil_Directivo_Alta = $resultado['Cuil_Directivo_Alta'];
$Cuil_Directivo_Baja = $resultado['Cuil_Directivo_Baja'];
$DniTutor = $resultado['DniTutor'];
$Nombre_Tutor = $resultado['Nombre_Tutor'];
$Cue_Establecimiento_Alta = $resultado['Cue_Establecimiento_Alta'];
$Escuela_Alta = $resultado['Escuela_Alta'];
$Directivo_Alta = $resultado['Directivo_Alta'];
$Domicilio_Esc_Alta = $resultado['Domicilio_Esc_Alta'];
$Cue_Establecimiento_Baja = $resultado['Cue_Establecimiento_Baja'];
$Escuela_Baja = $resultado['Escuela_Baja'];
$Directivo_Baja = $resultado['Directivo_Baja'];
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
$Tel_Rte_Acta = $resultado['Tel_Rte_Alta'];
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
<p align="center" class="Estilo1">Acta de Migración del Programa Conectar Igualdad</p>
<p align="center" class="Estilo1">de la Jurisdicción</p>
<p align="center" class="Estilo1">&nbsp;  </p>
<p class="estiloActa">Entre  la Autoridad Educativa Provincial  representada en este acto por el Sr./a:……………<?php echo $Directivo_Baja?>……………….., DNI  Nº………<?php echo $Cuil_Directivo_Baja?>.…….,en su carácter de Director/a del Colegio ……………<?php echo $Escuela_Baja?>………,  CUE: …………<?php echo $Cue_Establecimiento_Baja?>………….. Distrito Escolar:…………<?php echo $Dpto_Esc_Baja?>………de la Ciudad de    ………………<?php echo $Localidad_Esc_Baja?>……Provincia  de …………MISIONES...… ,con domicilio  ………<?php echo $Domicilio_Esc_Baja?>………….., en adelante “EL CEDENTE” y por la otra parte el /la Sr./a:………………………<?php echo $Directivo_Alta?>……………….., DNI  Nº……<?php echo $Cuil_Directivo_Alta?>…….,en su carácter de Director/a del Colegio ………………<?php echo $Escuela_Alta?>………,  CUE: …………<?php echo $Cue_Establecimiento_Alta?>………….. Distrito Escolar:…………<?php echo $Dpto_Esc_alta?>………de la Ciudad de    ………………<?php echo $Localidad_Esc_Alta?>……Provincia  de …………MISIONES...… ,con domicilio  ………<?php echo $Domicilio_Esc_Alta?>…………..,en  adelante  “EL RECEPCIONISTA”   , convienen por  la presenta acta  la migración del alumno  …....<?php echo $Nombre_Titular?>.....…………, CUIL Nº: ……<?php echo $Cuil_Titular?>……..,comodatario de la netbook modelo:………<?php echo $Modelo_Net?>……,  serie Nº:………<?php echo $SerieEquipo?>………., del establecimiento con director/a CEDENTE al  establecimiento con director/a RECEPCIONISTA a fin de ser incorporado en la  planta de alumnos comodatarios del establecimiento con director “RECEPCIONISTA”  y la registración en el servidor del mismo establecimiento para otorgar los  correspondientes certificados de seguridad, dejando de estar vinculada en el  establecimiento con director “CEDENTE”.<br />
  En prueba de conformidad  se firman TRES (3) ejemplares de un mismo tenor y a un solo efecto, por EL  CEDENTE y por  EL RECEPCIONISTA en la  ciudad  de………<?php echo $Localidad_Esc_Baja?>..…..Provincia de…<strong>MISIONES</strong>…,  a la Fecha.....<?php echo $Fecha_Pase?>.....<span class="Estilo2">&nbsp;</span></p>
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