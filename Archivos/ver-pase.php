<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Constancia de pase</title>
<style type="text/css">
<!--
.Estilo1 {
font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 22pt;
	font-weight:bold;
	border:thin #000000 solid;
	margin-left:16px;
	padding:5px 0px;
}
.Estilo2{
font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 20px;
	font-weight:bold;
}
.recuadro{
border:thin solid #000000;
}
.rec{
border-right:thin #000000 solid;
border-top:thin #000000 solid;
border-bottom:thin #000000 solid;

}
.right{
border-left:none;
}
.abajon{
border-bottom:none;
}
.left{
border-right:none;
}
.margen{
margin-left:5px;
}
#wrapper{
height:1110px;
}
body{
margin-top: -55px;
padding: 10px 0px;
}
-->
</style>
</head>
<body>
<?php
include('../../conexion.php');
//TRAIGO DATOS DEL serv de la otra esc
$qe = "SELECT * FROM directivos as d, datos_escuela as e, alumno as a WHERE e.id_esc = a.escuela AND d.datos_escuela_id_esc = a.escuela AND a.id = $_GET[id]";
$resp = mysql_query($qe);
while($b = mysql_fetch_array($resp)){
$estaba = $b['establecimiento'];
$adma = $b['nombre'];
$mailad = $b['correo'];
$tela = $b['tel_esc'];
}

//TRAIGO DATOS DEL serv de mi escuela
$q2 = "SELECT num_s FROM servidor as s WHERE s.datos_escuela_id_esc = '1'";
$re2 = mysql_query($q2);
while($b = mysql_fetch_row($re2)){
$servidor = $b[0];
}

//TRAIGO DATOS DEL DIRECTOR y mi escuela
$q3 = "SELECT * FROM directivos as d, datos_escuela as e WHERE d.cargo_idcargo = 1 AND d.datos_escuela_id_esc = e.id_esc AND d.datos_escuela_id_esc = 1";
$re3 = mysql_query($q3);
while($d = mysql_fetch_array($re3)){
$dir = $d['apellido']." ".$d['nombre'];
//dni director
$cuild=$d['cuil'];
$dnid = explode("-", $cuild);
$estab = $d['establecimiento'];
$cueb = $d['cue'];
$telesc = $d['tel_esc'];
$localidad = $d['localidade'];
$provincia = $d['provincia'];
}
//traigo datos del alumno(tutor etc) la net y que admin hizo el pase
$q4 = "select * FROM alumno as a, directivos as d, constancias as c, fecha_const as fc left join netbook on fc.netbook_id_net = id_net, datos_escuela as es WHERE a.escuela = es.id_esc AND fc.directivo = d.iddirectivos AND fc.constancia = c.idconstancias AND fc.tipo = 'p' AND c.alumno = a.id AND a.id = $_GET[id] AND pase is not null order by fecha desc limit 1";
$re4 = mysql_query($q4);
while($f = mysql_fetch_array($re4)){
//dni tutor
$cuilt=$f['cuilt'];
$dnit = explode("-", $cuilt);
//dni alumno
$cuila=$f['cuila'];
$dnia = explode("-", $cuila);
//datos admin
$adb = $f['apellido']." ".$f['nombre'];
$adbc = $f['correo'];
?>
    <div align="center" id="wrapper" style="margin: 20px 0px;padding: 20px;">
<table width="760" border="0">
  <tr>
    <td style="border-bottom:thin #000000 solid" align="center"><img src="../../img/ENCABEZADO.jpg"></td>
  </tr>
</table>
<br />
<table width="760" cellspacing="0">
<tr>
<td width="356" align="center" valign="middle" class="Estilo1">CONSTANCIA DE PASE</td>
<td width="120">&nbsp;</td>
<td width="117" align="center" valign="middle" class="Estilo2 recuadro">N&deg; TICKET </td>
<td width="147" border="0" class="rec">&nbsp;</td>
</tr>
</table>
<br />
<table width="760" class="recuadro abajon" cellspacing="0">
  <tr width="750">
    <td width="28"align="center" valign="bottom" class="abajon">&nbsp;</td>
    <td width="218" height="30" align="left" valign="bottom"><b>ALUMNO/A</b></td>
    <td width="244"></td>
    <td width="113"></td>
	<td width="113"></td>
	<td width="28"></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">APELLIDO Y NOMBRES</td>
    <td colspan="3" class="recuadro right abajon"><span class="margen"><?php echo $f['apa']." ".$f['noma'];?></span></td>
    <td width="28"></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro">CUIL N&ordm;</td>
    <td colspan="3" class="recuadro right"><span class="margen">
      <?php if ($dnia[1]==""){
echo "... - ".$cuila." - ...";
}else{
echo $cuila;}?>
    </span></td>
    <td "recuadro right">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
    <td align="left" valign="bottom" class=""><b>TUTOR/A</b></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon"></td>
    <td align="right" class="recuadro abajon"><b>APELLIDO Y NOMBRES</b></td>
    <td colspan="3" class="recuadro right abajon"><span class="margen"><?php echo $f['apt']." ".$f['nomt'];?></span></td>
    <td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">DNI N&deg;</td>
    <td colspan="3" class="recuadro right abajon"><span class="margen">
      <?php if ($dnit[1]==""){
echo $cuilt;
}else{
echo $dnit[1];}?>
    </span></td>
    <td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon"></td>
    <td align="right" class="recuadro abajon">DOMICILIO</td>
    <td colspan="3" class="recuadro right abajon"><span class="margen"><?php echo $f['dom'];?></span></td>
	<td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">LOCALIDAD</td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $f['loc'];?></span></td>
    <td class="recuadro right abajon" align="right">PROVINCIA</td>
    <td class="recuadro right abajon"><span class="margen">MISIONES</span></td>
	<td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro">TEL&Eacute;FONO</td>
    <td class="recuadro right"><span class="margen"><?php echo $f['tel'];?></span></td>
    <td class="recuadro right" align="right">CELULAR</td>
	<td class="recuadro right">&nbsp;</td>
  </tr>
  <tr width="750">
    <td width="28" align="center" valign="bottom" class="abajon">&nbsp;</td>
    <td width="218" height="30" align="left" valign="bottom"><b>NETBOOK A TRANSFERIR</b></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">N&ordm; DE SERIE </td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $f['serie'];?></span></td>
    <td class="recuadro right abajon">ID HARDWARE </td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $f['idhard'];?></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro">SPECIAL NUMBER(S/N) </td>
    <td colspan="3" class="recuadro right"><span class="margen"><?php echo $f['sn'];?></span></td>
<td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
    <td align="left" valign="bottom" class="" colspan="2"><b>INSTITUCION RESPONSABLE DE LA BAJA</b></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">ESTABLECIMIENTO</td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $estab;?></span></td>
    <td class="recuadro right abajon">CUE</td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $cueb;?></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon"></td>
    <td align="right" class="recuadro abajon">DIRECTOR/A</td>
    <td width="244" class="recuadro right abajon"><span class="margen"><?php echo $dir;?></span></td>
    <td class="recuadro right abajon">CUIL</td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $cuild;?></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">ADMIN DE RED </td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $adb;?></span></td>
    <td class="recuadro right abajon">TELEFONO</td>
 <td class="recuadro right abajon"><span class="margen"><?php echo $telesc;?></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">E-MAIL</td>
    <td colspan="3" class="recuadro right abajon"><span class="margen"><?php echo $adbc;?></span></td>
    <td></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro">N&ordm; DE SERVIDOR </td>
    <td colspan="3" class="recuadro right"><span class="margen"><?php echo $servidor;?></span></td>
    <td></td>
  </tr>
  <tr>
  <td height="70">&nbsp;</td>
  </tr>
  <tr>
  </tr>
  
</table>
<table width="760" class="recuadro" style="border-top:none; margin-top:-2px;">
<tr>
<td width="49"></tr>
  <td height="37">&nbsp;</td>
  <td width="193" align="center" valign="top" style="border-top:#000000 solid 1px;">FIRMA ADM. DE RED</td>
   <td width="25">&nbsp;</td>
   <td width="193" align="center" valign="top" style="border-top:#000000 solid 1px;">FIRMA TUTOR/A
    <td width="25">&nbsp;</td>
    <td width="193" align="center" valign="top" style="border-top:#000000 solid 1px;">FIRMA DIRECTOR/A</td>
	<td width="49">&nbsp;</td>
</tr>
</table><br />
<table width="760" class="recuadro abajon" cellspacing="0">
    <tr>
    <td width="28" align="right">&nbsp;</td>
    <td colspan="2" height="30" align="left" valign="bottom"><b>INSTITUCION RESPONSABLE DE LA ALTA </b></td>
    <td width="113" >&nbsp;</td>
    <td width="113" >&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td width="218" align="right" class="recuadro abajon">ESTABLECIMIENTO</td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $estaba;?></span></td>
    <td class="recuadro right abajon">CUE</td>
    <td class="recuadro right abajon"><span class="margen"></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon"></td>
    <td align="right" class="recuadro abajon">DIRECTOR/A</td>
    <td width="244" class="recuadro right abajon"><span class="margen"></span></td>
    <td class="recuadro right abajon">CUIL</td>
    <td class="recuadro right abajon"><span class="margen"></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">ADMIN DE RED </td>
    <td class="recuadro right abajon"><span class="margen"><?php echo $adma;?></span></td>
    <td class="recuadro right abajon">TELEFONO</td>
 <td class="recuadro right abajon"><span class="margen"><?php echo $tela;?></span></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro abajon">E-MAIL</td>
    <td colspan="3" class="recuadro right abajon"><span class="margen"><?php echo $mailad;?></span></td>
    <td width="28"></td>
  </tr>
  <tr>
    <td align="right" class="right abajon">&nbsp;</td>
    <td align="right" class="recuadro">N&ordm; DE SERVIDOR </td>
    <td colspan="3" class="recuadro right"><span class="margen"></span></td>
    <td></td>
  </tr>
  <tr>
  <td height="70">&nbsp;</td>
  </tr>
</table>
<table width="760" class="recuadro" style="border-top:none; margin-top:-2px;">
<tr>
<td width="49"></tr>
  <td height="37">&nbsp;</td>
  <td width="193" align="center" valign="top" style="border-top:#000000 solid 1px;">FIRMA ADM. DE RED</td>
   <td width="25">&nbsp;</td>
   <td width="193"><td width="25">&nbsp;</td>
    <td width="193" align="center" valign="top" style="border-top:#000000 solid 1px;">FIRMA DIRECTOR/A</td>
	<td width="49">&nbsp;</td>
</tr>
</table>
  </table>
</div>
<div id="wrapper">
<?php
include('pase2.php');
?>
</div>
<?php
}
?>
</body>
</html>