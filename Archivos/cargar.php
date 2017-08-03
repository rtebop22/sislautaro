<table id="nuevo">
<form action="nuevo.php" method="get" target="_blank">
<tr>
<th colspan="2">Cargar Datos Alumnos</th>
</tr>
<tr>
<td>Curso</td>
<td><select name="cur">
<?php
include('conexion.php');
$q = "SELECT * FROM curso order by curso asc";
$re = mysql_query($q);
while($row = mysql_fetch_array($re)){
	if($row['idcurso'] == 1 || $row['idcurso'] == 2){
echo "<option id=\"m\" value='".$row['idcurso']."'disabled=\"true\">$row[curso]</option>";
}else{
	echo "<option id=\"m\" value='".$row['idcurso']."'>$row[curso]</option>";
}}
?>
</select></td>
</tr>
<tr><td colspan="2" align="center"><input id="boton" type="submit" value="Cargar"/></td>
</tr>
</form>
<tr>
<th colspan="2">INFO</th>
</tr>
<tr>
<th colspan="2">Estado-NETS</th>
</tr>
<tr>
<?php //comienzan los datos estadisticos
$qq2= "SELECT id_net from netbook as n, estado as e where e.idestado = 2 AND n.estado_idestado = e.idestado";//nets sin asignar
$req2 = mysql_query($qq2);
echo "<td width=\"120px\">nets robadas</td><td align=\"center\"><a class=\"links\" href=\"index.php?r\">".mysql_num_rows($req2)."</a></td></tr>";
$q2= "SELECT id_net from netbook as n, estado as e where e.idestado <> 2 AND n.estado_idestado = e.idestado AND not exists(select netbook_id_net from alumno where netbook_id_net = n.id_net) AND not exists(select netbook_id_net from directivos where netbook_id_net = n.id_net)";//nets sin asignar
$re2 = mysql_query($q2);
echo "<td>nets osiosas</td><td align=\"center\"><a class=\"links\" href=\"index.php?v\">".mysql_num_rows($re2)."</a></td></tr>";
$qb2= "SELECT id_net from netbook as n, estado as e where e.idestado = 4 AND n.estado_idestado = e.idestado";//nets sin asignar
$reb2 = mysql_query($qb2);
echo "<td>Problemas</td><td align=\"center\"><a class=\"links\" href=\"index.php?pr\">".mysql_num_rows($reb2)."</a></td></tr>";
echo"<tr>
<th colspan=\"2\">Estado-Alumnos</th>
</tr>";
$q3= "SELECT netbook_id_net from alumno where not exists(select netbook_id_net from netbook where netbook_id_net = id_net) and curso_idcurso<>1 and curso_idcurso<>2";//alumnos sin nets
$re3 = mysql_query($q3);
if(mysql_num_rows($re3)!=0){
	echo "<tr><td>alumnos s/net</td><td align=\"center\"><a class=\"links\" style=\"color:red\" href=\"index.php?a\">".mysql_num_rows($re3)."</a></td></tr>";
}else {
	echo "<tr><td>alumnos s/net</td><td align=\"center\"><a class=\"links\" href=\"index.php?a\">".mysql_num_rows($re3)."</a></td></tr>";
}
$hoy = date("Y");
$pasado = $hoy-1;
$q4= "SELECT * from alumno as a INNER JOIN curso ON curso_idcurso = idcurso left join constancias on alumno = id where a.curso_idcurso=1 AND idcurso=a.curso_idcurso AND year(liberado) between '$pasado' AND NOW()";//alumnos egresados
$re4 = mysql_query($q4);
echo "<tr><td>egresados</td><td align=\"center\"><a class=\"links\" href=\"index.php?eg\">".mysql_num_rows($re4)."</a></td></<tr>";
$q5= "SELECT * from alumno as a INNER JOIN curso ON curso_idcurso = idcurso left join constancias on alumno = id where a.curso_idcurso=2 or idcurso=a.curso_idcurso AND year(pase) between '$pasado' AND year(NOW()) or pase is not null";//alumnos con pases excepto egresados
$re5 = mysql_query($q5);
echo "<tr><td>pases</td><td align=\"center\"><a class=\"links\" href=\"index.php?pa\">".mysql_num_rows($re5)."</a></td></<tr>";
$q6= "SELECT * from alumno, constancias WHERE curso_idcurso is null AND alumno = id AND year(deserto) between '$pasado' AND year(NOW())";//alumnos que abandonaron
$re6 = mysql_query($q6);
echo "<tr><td>Abondonó</td><td align=\"center\"><a class=\"links\" href=\"index.php?d\">".mysql_num_rows($re6)."</a></td></<tr>";
?>
</tr>
<th colspan="2">Alumnos en total</th>
<?php 
$qq= "SELECT sexa from alumno where curso_idcurso <> 1 AND curso_idcurso <> 2";
$resqq = mysql_query($qq);
$nenas = 0;
$nenes = 0;
while($al = mysql_fetch_array($resqq)){
if($al['sexa']==="f"){
$nenas++;
}else if($al['sexa']==="m"){
$nenes++;
}    
}
$total = $nenes+$nenas;
?>
<tr><td align="center"><img src="img/nena.png"><?php echo $nenas;?></td><td align="center" rowspan="2"><a id="total" href="index.php?busca="><?php echo $total;?></a></td></tr>
<tr><td align="center"><img src="img/nene.png"><?php echo $nenes;?></td></tr>
</tr>
<?php 
$qw = "SELECT * FROM directivos as d, datos_escuela as e WHERE d.cargo_idcargo = 1 AND d.datos_escuela_id_esc = e.id_esc AND d.datos_escuela_id_esc = 1";
$res = mysql_query($qw);
while($d = mysql_fetch_array($res)){
echo "<tr><th colspan=\"2\" align=\"center\">".$d['establecimiento']."</th></tr>";
echo "<tr><td style=\"width:20px\">TEL:</td><td>".$d['tel_esc']."</td></tr>";
echo "<tr><td>Director:</td><td>".$d['apellido']." ".$d['nombre']."</td></tr>";
echo "<tr><td>CUIL:</td><td>".$d['cuil']."</td></tr>";
echo "<tr><td>Correo:</td><td>".$d['correo']."</td></tr>";
echo "<tr><td>CUE:</td><td>".$d['cue']."</td></tr>";
}?>
</table>