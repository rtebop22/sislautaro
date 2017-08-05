<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta

	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Ubicacion=1') as $row1) {  
	$DentroEscuela=$row1['COUNT(*)'];
	//echo $hardware;
	}  
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Ubicacion=2') as $row2) {  
	$FueraEscuela=$row2['COUNT(*)'];
	//echo $hardware;
	}


	//
	$datos = array($DentroEscuela,$FueraEscuela);
	$leyenda = array("Dentro de la Escuela ($DentroEscuela)","Fuera de la Escuela ($FueraEscuela)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Segun la Ubicación");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
