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
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=1') as $row2) {  
	$Bateria=$row2['COUNT(*)'];

	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=2') as $row3) {  
	$Bloqueada=$row3['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=3') as $row4) {  
	$BotonEncendido=$row4['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=4') as $row5) {  
	$Cargador=$row5['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=5') as $row6) {  
	$ConfiguracionesIncorrectas=$row6['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=6') as $row7) {  
	$PassWindows=$row7['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=7') as $row8) {  
	$PassBios=$row8['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=8') as $row9) {  
	$Disco=$row9['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=9') as $row10) {  
	$FlexDisco=$row10['COUNT(*)'];
	
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=10') as $row11) {  
	$FlexPantalla=$row11['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=11') as $row12) {  
	$Grub=$row12['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=12') as $row13) {  
	$ImagenSO=$row13['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=13') as $row14) {  
	$Linux=$row14['COUNT(*)'];
	
	
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=14') as $row15) {  
	$NoDesbloquea=$row15['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=15') as $row16) {  
	$NoEnciende=$row16['COUNT(*)'];
	
	//echo $hardware;
	} foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=16') as $row17) {  
	$NoInicia=$row17['COUNT(*)'];
	
	//echo $hardware;
	} 
	 foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=17') as $row18) {  
	$Otro=$row18['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=18') as $row19) {  
	$FallaApp=$row19['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=19') as $row20) {  
	$Office=$row20['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=20') as $row21) {  
	$Pantalla=$row21['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=21') as $row22) {  
	$Parlante=$row22['COUNT(*)'];}
	//echo $hardware;
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=22') as $row23) {  
	$PinCarga=$row23['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=23') as $row24) {  
	$PlacaMadre=$row24['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=24') as $row25) {  
	$PlacaWifi=$row25['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=25') as $row26) {  
	$Teclado=$row26['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=26') as $row27) {  
	$Touchpad=$row27['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=27') as $row28) {  
	$Tv=$row28['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=28') as $row29) {  
	$Virus=$row29['COUNT(*)'];}
	
	foreach($dbh->query('SELECT COUNT(*) FROM detalle_atencion where Id_Problema=29') as $row30) {  
	$Windows=$row30['COUNT(*)'];}
	

	



	//Verifico que no esten vacios
	
	
	
	
	
	
	//Creo el Array
	$datos = array($Bateria,$Bloqueada,$BotonEncendido,$Cargador,$ConfiguracionesIncorrectas,$PassWindows,$PassBios,$Disco,$FlexDisco,$FlexPantalla,$Grub,$ImagenSO,$Linux,$NoDesbloquea,$NoEnciende,$NoInicia,$Otro,$FallaApp,$Office,$Pantalla,$Parlante,$PinCarga,$PlacaMadre,$PlacaWifi,$Teclado,$Touchpad,$Tv,$Virus,$Windows);
	$leyenda = array("BATERIA ($Bateria)","BLOQUEADA ($Bloqueada)","BOTON ENCENDIDO ($BotonEncendido)","CARGADOR ($Cargador)","CONFIGURACIONES INCORRECTAS ($ConfiguracionesIncorrectas)","PASS WINDOWS ($PassWindows)","PASS BIOS ($PassBios)","DISCO ($Disco)","FLEX DE DISCO ($FlexDisco)","FLEX PANTALLA ($FlexPantalla)","GRUB ($Grub)","IMAGEN S.O ($ImagenSO)","LINUX ($Linux)","NO TOMA DESBLOQUEO/CERTIF ($NoDesbloquea)","NO ENCIENDE ($NoEnciende)","NO INICIA ($NoInicia)","OTRO ($Otro)","FALLA APP ($FallaApp)","OFFICE ($Office)","PANTALLA ($Pantalla)","PARLANTE ($Parlante)","PIN DE CARGA ($PinCarga)","PLACA MADRE ($PlacaMadre)","PLACA WIFI ($PlacaWifi)","TECLADO ($Teclado)","TOUCHPAD ($Touchpad)","TV DIGITAL ($Tv)","VIRUS ($Virus)","WINDOWS ($Windows)");
	 
	//Se define el grafico
	$grafico = new PieGraph(850,800);
	
	//Definimos el titulo 
	$grafico->title->Set("Segun el Problemas");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.35);
		 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
