<link rel="stylesheet" type="text/css" href="EstiloActa.css">

<?php 

$action='Generar';
switch ($action)
{
    case 'Generar':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        $IdAtencion= $_GET['Id_Atencion'];
	    break;
    default :
}
?>
<?php
$link = mysqli_connect("localhost", "root", "sistema");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "SELECT atencion_equipos.Id_Atencion AS Id_Atencion,
  atencion_equipos.Dni AS Dni,
  personas.Apellidos_Nombres AS Nombre,
  atencion_equipos.NroSerie AS NroSerie,
  cursos.Descripcion AS Curso,
  atencion_equipos.Fecha_Entrada AS Fecha,
  atencion_equipos.Usuario AS Usuario,
  tipo_falla.Descripcion AS Falla,
  problema.Descripcion AS Problema,
  detalle_atencion.Descripcion_Problema AS Descripcion,
  tipo_solucion_problema.Descripcion AS Solucion,
  estado_actual_solucion_problema.Descripcion AS Estado
FROM atencion_equipos
  INNER JOIN detalle_atencion ON atencion_equipos.Id_Atencion =
    detalle_atencion.Id_Atencion AND atencion_equipos.NroSerie =
    detalle_atencion.NroSerie
  INNER JOIN personas ON atencion_equipos.Dni = personas.Dni
  INNER JOIN cursos ON personas.Id_Curso = cursos.Id_Curso
  INNER JOIN division ON personas.Id_Division = division.Id_Division
  INNER JOIN tipo_falla ON detalle_atencion.Id_Tipo_Falla =
    tipo_falla.Id_Tipo_Falla
  INNER JOIN problema ON detalle_atencion.Id_Problema = problema.Id_Problema
  INNER JOIN tipo_solucion_problema ON detalle_atencion.Id_Tipo_Sol_Problem =
    tipo_solucion_problema.Id_Tipo_Sol_Problem
  INNER JOIN estado_actual_solucion_problema ON detalle_atencion.Id_Estado_Atenc
    = estado_actual_solucion_problema.Id_Estado_Atenc
WHERE atencion_equipos.Id_Atencion = $IdAtencion");
$resultado= mysqli_fetch_array($consulta);
//if ($resultado){
$Id_Atencion = $resultado['Id_Atencion'];
$Dni = $resultado['Dni'];
$Nombre = $resultado['Nombre'];
$NroSerie = $resultado['NroSerie'];
$Curso = $resultado['Curso'];
$Fecha = $resultado['Fecha'];
$Usuario = $resultado['Usuario'];
$Falla = $resultado['Falla'];
$Problema = $resultado['Problema'];
$Descripcion = $resultado['Descripcion'];
$Solucion = $resultado['Solucion'];
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
.Estilo6 {font-size: 24px; font-weight: bold; }
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
<style type="text/css">
<!--
.Estilo1 {
	font-size: 24px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo12 {font-size: 24px}
-->
</style>
<div id="muestra">
<table width="99%" border="1" cellpadding="0" cellspacing="0" margin-right: 10%>
  <tr>
    <th width="7%" scope="col"><div align="center">Original..</div></th>
    <th width="93%" bordercolor="#000000" scope="col"> <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <th height="83" scope="col"><p align="center" class="Estilo1">Sistema de Gesti&oacute;n Conectar Igualdad </p>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Usuario: <?php echo $Usuario?> </th>
                    <th scope="col"><span class="Estilo6">Tiket de la Atenci&oacute;n </span></th>
                    <th scope="col">Fecha Entrada: <?php echo $Fecha?></th>
                  </tr>
                </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Titular:</th>
                    <th scope="col"><?php echo $Nombre?></th>
                    <th scope="col">Dni</th>
                    <th scope="col"><?php echo $Dni?></th>
                    <th scope="col">Curso</th>
                    <th scope="col"><?php echo $Curso?></th>
                    <th scope="col">Serie Equipo</th>
                    <th scope="col"><?php echo $NroSerie?></th>
                  </tr>
                </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Nro Atenci&oacute;n </th>
                    <th scope="col">Tipo Falla</th>
                    <th scope="col">Problema</th>
                    <th scope="col">Descripci&oacute;n</th>
                    <th scope="col">Soluci&oacute;n</th>
                    <th scope="col">Estado Actual </th>
                  </tr>
                  <tr>
                    <th scope="row"><div align="center"><?php echo $Id_Atencion?></div></th>
                    <td><div align="center"><?php echo $Falla?></div></td>
                    <td><div align="center"><?php echo $Problema?></div></td>
                    <td><div align="center"><?php echo $Descripcion?></div></td>
                    <td><div align="center"><?php echo $Solucion?></div></td>
                    <td><div align="center"><?php echo $Estado?></div></td>
                  </tr>
                </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Datos Extras</th>
                    <th scope="col">Contrase&ntilde;a:______________________________________</th>
                    <th scope="col">Fecha Retiro :_______________________________________________</th>
                  </tr>
                </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Datos de Servicio T&eacute;cnico (Completa el T&eacute;cnico Escolar, no el ALUMNO) </th>
                  </tr>
                </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Nro de Tiket </th>
                    <th scope="col">_______________________</th>
                    <th scope="col">Escuela:</th>
                    <th scope="col">_______________________</th>
                  </tr>
              </table></th>
      </table></th>
  </tr>
</table>
</p>
  </p>
  <table width="99%" border="1" cellpadding="0" cellspacing="0" margin-right:="margin-right:" 10%>
    <tr>
      <th width="7%" scope="col"><div align="center">Duplicado</div></th>
      <th width="93%" bordercolor="#000000" scope="col"> <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th height="83" scope="col"><p align="center" class="Estilo1">Sistema de Gesti&oacute;n Conectar Igualdad </p>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Usuario: <?php echo $Usuario?> </th>
                    <th scope="col"><span class="Estilo6">Tiket de la Atenci&oacute;n </span></th>
                    <th scope="col">Fecha Entrada: <?php echo $Fecha?></th>
                  </tr>
                </table>
              <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Titular:</th>
                    <th scope="col"><?php echo $Nombre?></th>
                    <th scope="col">Dni</th>
                    <th scope="col"><?php echo $Dni?></th>
                    <th scope="col">Curso</th>
                    <th scope="col"><?php echo $Curso?></th>
                    <th scope="col">Serie Equipo</th>
                    <th scope="col"><?php echo $NroSerie?></th>
                  </tr>
                </table>
              <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col">Nro Atenci&oacute;n </th>
                    <th scope="col">Tipo Falla</th>
                    <th scope="col">Problema</th>
                    <th scope="col">Descripci&oacute;n</th>
                    <th scope="col">Soluci&oacute;n</th>
                    <th scope="col">Estado Actual </th>
                  </tr>
                  <tr>
                    <th scope="row"><div align="center"><?php echo $Id_Atencion?></div></th>
                    <td><div align="center"><?php echo $Falla?></div></td>
                    <td><div align="center"><?php echo $Problema?></div></td>
                    <td><div align="center"><?php echo $Descripcion?></div></td>
                    <td><div align="center"><?php echo $Solucion?></div></td>
                    <td><div align="center"><?php echo $Estado?></div></td>
                  </tr>
                </table>
          </table>
      </th>
    </tr>
  </table>
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