<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta
	/*  
	$hostname="localhost";  
	$username="root";  
	$password="sistema";  
	$db = "sistemadecontrol";  
	$dbh = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);  
*/
	//CONSULTAS DE TODOS LOS PROBLEMAS
	
	foreach($dbh->query('SELECT COUNT(*) FROM atencion_para_st where Id_Tipo_retiro=1') as $row1) {  
	$Pendiente=$row1['COUNT(*)'];
	}
	foreach($dbh->query('SELECT COUNT(*) FROM atencion_para_st where Id_Tipo_retiro=3') as $row2) {  
	$Controlado=$row2['COUNT(*)'];
	}
	
	
	//Creo el Array
	$datos = array($Pendiente,$Controlado);
	$leyenda = array("Pendientes ($Pendiente)","Retirados ($Controlado)");
	 
	//Se define el grafico
	$grafico = new PieGraph(200,200);
	
	//Definimos el titulo 
	$grafico->title->Set("Control retiro");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
		 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
