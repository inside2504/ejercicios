<?php
	
	//#! Config
	// Aquí va la configuración básica del script
	// Path para llamar el XML
	$path_xml = 'soccer.xml';
	//#! Basics
	// Funciones básicas del script
	
	// Construye un template con el item de la categorí
	/*
		@param List $arr
			*item String $id ID del elemento
			*item String $name Nombre a imprimir
	 */
	function node_template ($arr) {
		// Creamos la opción para el SELECT, le asignamos valor y nombre. Imprimimos
		return '<option value="' . $arr['id'] . '">' . $arr['name'] . '</option>';
	}
	// Construye un template con el item de los matches
	/*
		@param List $arr
			*item String $id ID del elemento
			*item String $name Nombre a imprimir
			*items SimpleXMLList Lista de matches para construir el template
	 */
	function match_template ($arr) {
		//var_dump($arr);
		// Creamos un DIV y le asignamos el ID
		$template = '<div class="match" data-ref="' . $arr['id'] . '"><table class="table">';
		// Iniciamos el ciclo foreach para comenzar a recorrer los nodos del XML
		foreach ($arr['matches']->match as $match) {
		 	$mtc = $match->attributes();
		 	$lcl = $match->localteam->attributes();
		 	$vst = $match->visitorteam->attributes();
		 	$evt = $match->events;
		 	$mnt = array();
		 	//Se declara una condicional para saber si existen eventos del partido.
		 	//Si existen entonces se cumple la condición E imprime los datos de los equipos, el resultado y los eventos del partido.
		 	if (count($evt>0)) {
		 		//Impresión de los atributos del XML
		 		$template .= '<tr><th>'. $mtc['status'] . '</th>';
		 		$template .= '<th>' . $mtc['formatted_date'] . $mtc['time'] . '</th></tr>';
				$template .= '<tr><td>'. $lcl['name'] . ' ' . $lcl['goals'] . '</td></tr>';
				$template .= '<td>'. $vst['name'] . ' ' . $vst['goals'] . '</td>';
				//Declaración de la variable para guardar el arreglo
		 		$mnt = array();
				//Ciclo donde se convierte en array los object SimpleXMLElement
				foreach ($evt->event as $value) {
					$mnt[] = $value; 
				}
				//Ordenamiento con arsort de forma descendente
				arsort($mnt,SORT_DESC);
				//Recorre los eventos del partido e imprime los atributos de cada uno de ellos.
				foreach ($mnt as $e) {
				 	$template .= '<td>'. $e['minute'] . '" | ' . $e['team'] . ' | ' . $e['type'] . ' | ' .  $e['player'] .'</td></tr>';
				 	$template .= '<td></td>';
				}
		 	}else{
		 		//En caso de que no se cumpla la condición solamente se imprimirán los nombres de los equipos y el marcador
			 	$template .= '<th>'. $mtc['status'] . '</th>';
			 	$template .= '<tr><td>'. $lcl['name'] . ' ' . $lcl['goals'] . '</td></tr>';
			 	$template .= '<tr><td>'. $vst['name'] . ' ' . $vst['goals'] . '</td></tr>';
			 	$template .= '<th>' . $mtc['formatted_date'] . $mtc['time'] . '</th>';			 	
			 }
		 }
		//Cierre de las etiquetas
		$template .= '</td></tr>';
		$template .= '</table></div>';
		// Imprimimos
		return $template;
	}
	//#! Main
	
	// Función que genera el HTML
	function load_xml ($path) {
		// Obtenemos el archivo XML
		$xml = simplexml_load_file ($path);
		// Creamos cache para las variables
		$nodeList = "";
		$matchesList = "";
		// Recorremos los nodos de categorías
		foreach ($xml->category as $node) {
			// Generamos un ID entrópico para no repetir
			// Obtenemos los atributos del nodo
			$attributes = $node->attributes();
			// Generamos una lista de los nodos seleccionable
			$nodeList .= node_template([
				'id' => $attributes['id'],
				'name' => $attributes['name'],
				'gid' => $attributes['gid'],
				'file_group' => $attributes['file_group']
				
			]);
			//Generamos las variables que contienen los atributos de los diferentes nodos del XML
			$category = $node;
			$matches = $node->matches;
			$match = $node->matches->match;
			$local = $node->matches->match->localteam;
			$visitor = $node->matches->match->visitorteam;
			$events = $node->matches->match->events;
			
			// Generamos una lista de los matches a buscar
			$matchesList .= match_template([
				'id' => $attributes['id'],
				'category' => $category,
				'matches' => $matches,
				'match' => $match,
				'local' => $local,
				'visitor' => $visitor,
				'events' => $events
			]);
		}
		// Imprimimos Nodos
		echo '<select id="category">';
		echo $nodeList;
		echo '</select>';
		// Imprimimos matches
		echo $matchesList;
	}
?>

<!DOCTYPE HTML>
<html>
<head>

<!-- Estilos -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
/* Ocultamos todos los matches por defecto */
.match {
	display: none;
	height: auto;
}
</style>

<!-- Scripts -->

<!-- Importamos jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	// Se ejecuta la función inicio del programa
	$(function () {
		// EVENT: Al cambiar de valor #category
		$('#category').on('change', function (e) {
			// prevenimos funciones hereditarias
			e.preventDefault();
			// Obtenemos el ID de acuerdo al valor actual de #category
			var uid = $(this).val();
			// Ocultamos todos los matches
			$('.match').hide();
			// Mostramos el match seleccionado
			$('[data-ref="' + uid + '"]').show();
		})
	});
</script>
</head>
<body>
<pre>

<!-- Imprimimos el HTML generado con PHP -->
<?php load_xml($path_xml); ?>

</pre>
</body>