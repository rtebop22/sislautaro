<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta
	
	//CONSULTAS DE TODOS LOS PROBLEMAS
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=1') as $row2) {  
	$EsperandoSt=$row2['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=2') as $row3) {  
	$EnSt=$row3['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=3') as $row4) {  
	$Solucionado=$row4['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=4') as $row5) {  
	$EnEspera=$row5['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=5') as $row6) {  
	$EsperandoPaquete=$row6['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=6') as $row7) {  
	$EsperandoCargador=$row7['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=7') as $row8) {  
	$Retirada=$row8['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Estado_Atenc=8') as $row9) {  
	$Otro=$row9['COUNT(*)'];
	
	//echo $hardware;
	} 	
	
	
	//Creo el Array
	$datos = array($EsperandoSt,$EnSt,$Solucionado,$EnEspera,$EsperandoPaquete,$EsperandoCargador,$Retirada,$Otro);
	$leyenda = array("ESPERANDO RETIRO P/SERV. TECNICO ($EsperandoSt)","EN SERV. TECNICO EXTERNO ($EnSt)","SOLUCIONADO, ESPERANDO RETIRO ($Solucionado)","EN ESPERA DE SOLUCION ($EnEspera)","ESPERANDO PAQUETE DE PROVISION ($EsperandoPaquete)","ESPERANDO CARGADOR/BAT. ($EsperandoCargador)","RETIRADO POR EL TITULAR ($Retirada)","OTRO ($Otro)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Segun los Estados");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
