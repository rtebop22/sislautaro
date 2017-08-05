
<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php 
$Operacion=$_GET['operacion'];
switch ($Operacion)

{
    case '1':
		$msj="Operacion Correcta";
		$imagen="correcto.png";
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        break;
	case '2':
		$msj="Operacion incorrecta, no se encontro el equipo en la base de datos de pedidos";
		$imagen="error.png";
		break;
	case '3':
		$msj="";
		$imagen="vacio.png";
		break;
		
    default :
}
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "header.php" ?>

<div class="ewToolbar"></div>
<form id="FormularioRetiro" name="FormularioRetiro" method="post" action="MarcarDevolucion.php">
  <p>
    <label>Nro de Serie:
    <input name="Serie" type="text" id="Serie" size="50" />
    </label>
    <input type="submit" name="Submit" value="Marcar Devoluci&oacute;n" />
  </p>
</form>
<script type="text/javascript">
window.onload= function(){
document.FormularioRetiro.Serie.focus()
}
</script>
<table width="50%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><?php echo $msj?>
	  <p><?php echo '<img src="phpimages/' . $imagen . '" /><br />';?></p>
  </tr>
</table>
<?php include_once "footer.php" ?>
