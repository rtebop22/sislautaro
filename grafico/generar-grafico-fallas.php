<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta

	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Falla=1') as $row1) {  
	$hardware=$row1['COUNT(*)'];
	//echo $hardware;
	}  
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Falla=2') as $row2) {  
	$software=$row2['COUNT(*)'];
	//echo $hardware;
	}


	//
	$datos = array($hardware,$software);
	$leyenda = array("Hardware ($hardware)","Software ($software)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Segun la Falla");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
