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
mysqli_select_db($link, "operativost");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "select * from pedido_st where NroSerie='$serie'");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
echo $NroSerie = $resultado['NroSerie'];
$Tiket = $resultado['Tiket'];
if ($NroSerie!=NULL){
$consulta = mysqli_query($link, "UPDATE pedido_st SET Id_Estado=4 WHERE NroSerie='$NroSerie'");
sleep(0);
header('Location: MarcarDevolucionStreport.php?operacion=1'); 
}else{
sleep(0);
header('Location: MarcarDevolucionStreport.php?operacion=2');  
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
