<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta
	
	//CONSULTAS DE TODOS LOS PROBLEMAS
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=1 and Tiene_Cargador="si"') as $row2) {  
	$Funcionando=$row2['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=2 and Tiene_Cargador="si"') as $row3) {  
	$EnParaSt=$row3['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=3 and Tiene_Cargador="si"') as $row4) {  
	$RemFunc=$row4['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=4 and Tiene_Cargador="si"') as $row5) {  
	$RemRoto=$row5['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=14 and Tiene_Cargador="si"') as $row6) {  
	$OtroEstadoEquipo=$row6['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=7 and Tiene_Cargador="si"') as $row7) {  
	$Robado=$row7['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=8 and Tiene_Cargador="si"') as $row8) {  
	$TransfPend=$row8['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=9 and Tiene_Cargador="si"') as $row9) {  
	$TransfComp=$row9['COUNT(*)'];}

	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=10 and Tiene_Cargador="si"') as $row10) {  
	$LibPend=$row10['COUNT(*)'];}

	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=11 and Tiene_Cargador="si"') as $row11) {  
	$LibComp=$row11['COUNT(*)'];}


	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=12 and Tiene_Cargador="si"') as $row12) {  
	$EnReparacion=$row12['COUNT(*)'];}


	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=13 and Tiene_Cargador="si"') as $row13) {  
	$PrestamoEsc=$row13['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=15 and Tiene_Cargador="si"') as $row14) {  
	$OciosaFunc=$row14['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=16 and Tiene_Cargador="si"') as $row15) {  
	$OciosaRota=$row15['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=17 and Tiene_Cargador="si"') as $row16) {  
	$ObsoletaFunc=$row16['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM equipos where Id_Sit_Estado=18 and Tiene_Cargador="si"') as $row17) {  
	$ObsoletaRota=$row17['COUNT(*)'];}

	//Creo el Array
	$datos = array($Funcionando,$EnParaSt,$RemFunc,$RemRoto,$OtroEstadoEquipo,$Robado,$TransfPend,$TransfComp,$LibPend,$LibComp,$EnReparacion,$PrestamoEsc,$OciosaFunc,$OciosaRota,$ObsoletaFunc,$ObsoletaRota);
	$leyenda = array("FUNCIONANDO ($Funcionando)","EN/PARA SERVICIO TECNICO ($EnParaSt)","REMANENTE FUNCIONANDO ($RemFunc)","REMANENTE ROTO($RemRoto)","OTRO ($OtroEstadoEquipo)","ROBO/EXTRAVIO ($Robado)","TRANSFERENCIA PENDIENTE ($TransfPend)","TRANSFERENCIA COMPLETA ($TransfComp)","LIBERACION PENDIENTE ($LibPend)","LIBERACION COMPLETA ($LibComp)","EN REPARACION ($EnReparacion)","PRESTAMO ESCOLAR ($PrestamoEsc)","OCIOSA FUNCIONANDO ($OciosaFunc)","OCIOSA ROTA ($OciosaRota)","OBSOLETA FUNCIONANDO ($ObsoletaFunc)","OBSOLETA ROTA ($ObsoletaRota)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Equipos con cargadores segun estados");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
