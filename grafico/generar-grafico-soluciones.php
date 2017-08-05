<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 include ("../conexion.php");
	// Se define el array de valores y el array de la leyenda
	
	//Realizamos la consulta
 
	//CONSULTAS DE TODOS LOS PROBLEMAS
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=1') as $row2) {  
	$Desbloquear=$row2['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=2') as $row3) {  
	$Reinstalar=$row3['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=3') as $row4) {  
	$Activar=$row4['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=4') as $row5) {  
	$SolicCargador=$row5['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=5') as $row6) {  
	$Formatear=$row6['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=6') as $row7) {  
	$Restaurar=$row7['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=7') as $row8) {  
	$ServicioTecnico=$row8['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=8') as $row9) {  
	$Sincronizar=$row9['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=9') as $row10) {  
	$Paquete=$row10['COUNT(*)'];
	
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=10') as $row11) {  
	$QuitarPass=$row11['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Tipo_Sol_Problem=11') as $row12) {  
	$Otro=$row12['COUNT(*)'];
	
	//echo $hardware;
	}

	//Verifico que no esten vacios
	
	
	
	
	
	
	//Creo el Array
	$datos = array($Desbloquear,$Reinstalar,$Activar,$SolicCargador,$Formatear,$Restaurar,$ServicioTecnico,$Sincronizar,$Paquete,$QuitarPass,$Otro);
	$leyenda = array("DESBLOQUEAR ($Desbloquear)","REINSTALAR ($Reinstalar)","ACTIVAR ($Activar)","SOLICITAR CARG./BATERIA ($SolicCargador)","FORMATEAR ($Formatear)","RESTAURAR ($Restaurar)","SERVICIO TECNICO ($ServicioTecnico)","SINCRONIZAR LLAVE ($Sincronizar)","SOLICITAR PAQUETE ($Paquete)","QUITAR CONTRASEÑA ($QuitarPass)","OTRO/A ($Otro)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Segun la Solucion");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
