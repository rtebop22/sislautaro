<?php
session_start();
include('../../conexion.php');
$est = $_POST['est'];
$admin = $_POST['admin'];
$mailad = $_POST['email'];
$tel = $_POST['tel'];
$nn = $_POST['nn'];
if($nn =="on"){
$nid="NULL";
}else{
$nid= $_POST['nid'];
}$id = $_GET['id'];
$sn = $_POST['sn'];
if ($est ==='' || $tel ==='' || $admin ==='' || $mailad ===''){
header("location:req.php?id=".$id."&err");
}else{
//inserto la escuela a la que se fue de pase
if (isset($est)|| isset($tel) && $est !='' && $tel !=''){
$q2 = "INSERT INTO datos_escuela (establecimiento, tel_esc) VALUES ('$est', '$tel')";
$re2 = mysql_query($q2);
$escu = mysql_insert_id();
}
//actualizo que el alumno pertenece a otra escuela.-
$al = "UPDATE alumno SET escuela = '$escu' WHERE id IN($id)";
mysql_query($al);
//si se introdujo datos del admin a la escuela a la que se fue inserto un nuevo admin
if (isset($admin)|| isset($mailad) && $admin !='' && $mailad !=''){
$q4 = "INSERT INTO directivos (nombre, correo, datos_escuela_id_esc, cargo_idcargo) VALUES ('$admin', '$mailad', '$escu', '4')";
$re4 = mysql_query($q4);
}
//actualizo que la net pertenece a otra escuela si no fue tildado se va sin net
if($nn =="on"){
$q1 ="UPDATE alumno SET netbook_id_net = null WHERE id IN($id)";
}else{
$q1 = "UPDATE netbook SET datos_escuela_id_esc = '$escu', sn = '$sn' WHERE id_net IN($nid)";
}
mysql_query($q1);
//actualizo muevo el alumno a pases
$q11 = "UPDATE alumno SET curso_idcurso = '2' WHERE id = $id";
mysql_query($q11);
//actualizo la info de cuando se hizo el pase y quien se lo hizo
    $p="SELECT * FROM constancias, alumno WHERE alumno = $id AND id = $id";
    $rp=mysql_query($p);
if(mysql_num_rows($rp)==0){//no existe constncia alguna
    $q7 = "INSERT INTO constancias(pase,alumno)values(NOW(),'$id')";
    mysql_query($q7);
    $cons=mysql_insert_id();
    $q8 = "INSERT INTO fecha_const(tipo,fecha,constancia,directivo,netbook_id_net)values('p',NOW(),'$cons',$_SESSION[user],$nid)";
    mysql_query($q8);
 }else{//existe
 $q7="UPDATE constancias SET pase = NOW() WHERE alumno = $id";
 mysql_query($q7);
$qt="SELECT idconstancias FROM constancias WHERE alumno = $id";
 $rt= mysql_query($qt);
 while($f = mysql_fetch_array($rt)){
$const = $f['idconstancias'];
 }
 $q8 = "INSERT INTO fecha_const(tipo,fecha,constancia,directivo,netbook_id_net)values('p',NOW(),'$const',$_SESSION[user],$nid)";
    mysql_query($q8);
 }
header("location:ver-pase.php?id=".$id);
}
?>