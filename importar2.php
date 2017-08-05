<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<body>
<h1>Importando archivo CSV</h1>
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
Importar Archivo : <input type="file" name="sel_file" size="20" />
<input type="submit" name="submit" value="submit" />
</form>
</body>
</html>

<?php
 
error_reporting(0);//apagamos todas la notificaciones
 
//verificamos que si se haya enviado un post.
if(isset($_POST['submit'])){
//obtenemos el nombre del archivo.
$fname = $_FILES['sel_file']['name'];
 
echo 'Cargando nombre del archivo: '.$fname.' ';
$chk_ext = explode(".",$fname);
 
//verificamos que el archivo tenga la extensión correcta para procesar la información
if(strtolower(end($chk_ext)) == "csv")
{
//Establecemos la conexión con nuestro servidor de mysql local
$cone = mysql_connect('localhost', 'root', 'sistema');
if(!$cone)//en caso de no lograr establecer la conexión se quiebra el proceso...
die('Conexion no establecida');
 
//Verificamos si nuestra base de datos existe.
if (!mysql_select_db("sistemadecontrol"))//en caso de no existir quiebra el proceso...
die("base de datos no existe");
 
//si es correcto, entonces damos permisos de lectura para subir
$filename = $_FILES['sel_file']['tmp_name'];
$handle = fopen($filename, "r");
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
{
echo strtoupper($data[0]);

//verificamos que la información no sean los nombre de las columnas.
if(strtoupper($data[0]) != '﻿"NROPEDIDO"'){
//Insertamos los datos con los valores...

$sql = "insert into Paquetes_Provision (NroPedido,NroSerie,Id_Hardware,SN,Marca_Arranque)";
$sql .= " values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')";
 
mysql_query($sql) or die(mysql_error());//mandamos a guardar en la base de datos. tabla cliente.
 
}
}
//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
fclose($handle);
echo "Importación exitosa!";
}else{
echo "Formato de archivo incorrecto";
}
 
}
 
?>
