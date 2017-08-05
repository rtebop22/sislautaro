<?php 
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
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
	}

// Se define el array de datos
$datosy=array($EsperandoSt,$EnSt,24,5,8,31);
 
// Creamos el grafico
$grafico = new Graph(500,250);
$grafico->SetScale('textlin');
 
// Ajustamos los margenes del grafico-----    (left,right,top,bottom)
$grafico->SetMargin(40,30,30,40);
 
// Creamos barras de datos a partir del array de datos
$bplot = new BarPlot($datosy);

// Configuramos color de las barras 
$bplot->SetFillColor('#479CC9');

// Queremos mostrar el valor numerico de la barra
$bplot->value->Show();

//Añadimos barra de datos al grafico
$grafico->Add($bplot);
 
// Configuracion de los titulos
$grafico->title->Set('Mi primer grafico de barras');
$grafico->xaxis->title->Set('Titulo eje X');
$grafico->yaxis->title->Set('Titulo eje Y');
 
$grafico->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
 
// Se muestra el grafico
$grafico->Stroke();
?>
