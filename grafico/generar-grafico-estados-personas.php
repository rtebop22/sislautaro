<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta
	
	//CONSULTAS DE TODOS LOS PROBLEMAS
	
	foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=1') as $row2) {  
	$Regular=$row2['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=2') as $row3) {  
	$AbanCEquipo=$row3['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=3') as $row4) {  
	$AbanSEquipo=$row4['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=4') as $row5) {  
	$EgresoCEquipo=$row5['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=5') as $row6) {  
	$EgresoSEquipo=$row6['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=6') as $row7) {  
	$Activo=$row7['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=7') as $row8) {  
	$Licencia=$row8['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=8') as $row8) {  
	$Otro=$row8['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=9') as $row8) {  
	$PaseCEquipo=$row8['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM personas where Id_Estado=10') as $row8) {  
	$PaseSEquipo=$row8['COUNT(*)'];}

	
	//Creo el Array
	$datos = array($Regular,$AbanCEquipo,$AbanSEquipo,$EgresoCEquipo,$EgresoSEquipo,$Activo,$Licencia,$Otro,$PaseCEquipo,$PaseSEquipo);
	$leyenda = array("REGULAR ($Regular)","ABANDONO CON EQUIPO ($AbanCEquipo)","ABANDONO SIN EQUIPO ($AbanSEquipo)","EGRESO CON EQUIPO ($EgresoCEquipo)","EGRESO SIN EQUIPO ($EgresoSEquipo)","ACTIVO/A ($Activo)","LICENCIA ($Licencia)","OTRO ($Otro)","PASE CON EQUIPO ($PaseCEquipo)","PASE SIN EQUIPO ($PaseSEquipo)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Estados de los Alumnos y Docentes");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
