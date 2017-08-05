<?php if (substr_count($_SERVER

['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering

?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php";
include ("conexion.php");
$serie= $_POST['Serie'];
$link = mysqli_connect("localhost", "root", "sistema");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "select * from atencion_para_st where NroSerie='$serie' and Id_Tipo_Retiro=1 order by Id_Atencion DESC limit 1");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
echo $NroSerie = $resultado['NroSerie'];
$Tiket = $resultado['Tiket'];
$IdAtencion = $resultado['Id_Atencion'];
$Control = $resultado['Id_Tipo_Retiro'];
if ($NroSerie!=NULL){
if ($Control==3){
//sleep(0);
header('Location: MarcarRetiroStreport.php?operacion=4'); 
}else{
$fecha=$Fecha=ew_CurrentDate();
$usuario='Administrador';
$consulta = mysqli_query($link, "UPDATE atencion_para_st SET Id_Tipo_Retiro=3, Fecha_Retiro='$fecha' WHERE NroSerie='$NroSerie' and Id_Atencion=$IdAtencion");
$consulta = mysqli_query($link, "UPDATE detalle_atencion SET Id_Estado_Atenc=2, Fecha_Actualizacion='$fecha' WHERE NroSerie='$serie' and Id_Atencion=$IdAtencion");
$consulta = mysqli_query($link, "UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$fecha',Usuario='$usuario' WHERE NroSerie='$serie'");
$consulta = mysqli_query($link, "INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra en Servicio Tecnico Externo', '$fecha' ,'$serie')");
$consulta = mysqli_query($link, "INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Servicio Tecnico Externo', '$fecha' ,'$serie','$usuario',$IdAtencion)");



//sleep(0);
header('Location: MarcarRetiroStreport.php?operacion=1'); 
}
}else{
//sleep(0);
header('Location: MarcarRetiroStreport.php?operacion=2');  
}

//mysqli_free_result($consulta);
mysqli_close($link);


?>

<?php 

//$dbh->query('select Id_Atencion from detalle_atencion where NroSerie='' and Id_Estado_Atenc=2') as $row1) {  
//$NroAtencion=$row1['Id_Atencion'];
?>

<?php ew_Header(TRUE) ?>


<?php include_once "header.php" ?>

<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php include_once "footer.php" ?>
