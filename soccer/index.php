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
			*item String $uid ID del elemento
			*item String $name Nombre a imprimir
	 */
	function node_template ($arr) {
		// Creamos la opción para el SELECT, le asignamos valor y nombre. Imprimimos
		return '<option value="' . $arr['uid'] . '">' . $arr['name'] . '</option>';
	}
	// Cosntruye un template con el item de los matches
	/*
		@param List $arr
			*item String $uid ID del elemento
			*item String $name Nombre a imprimir
			*item SimpleXMLList $matches Lista de matches para construir el template
	 */
	function match_template ($arr) {
		// Creamos un DIV y le asignamos el ID
		$template = '<div class="match" data-ref="' . $arr['uid'] . '"><ul>';
		// Creamos el título de la lista
		$template .= '<li><h4>' . $arr['name'] . '</h4></li>';
		$template .= '</ul></div>';
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
			echo var_dump ($node);
			// Generamos un ID entrópico para no repetir
			$uid = uniqid('prefix', true);
			// Obtenemos los atributos del nodo
			$attributes = $node->attributes();
			// Generamos una lista de los nodos seleccionable
			$nodeList .= node_template([
				'uid' => $uid,
				'name' => $attributes['name']
				
			]);
			// Generamos una lista de los matches a buscar
			$matchesList .= match_template([
				'uid' => $uid,
				'name' => $attributes['name'],
				'matches' => $node->matches
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

<!-- Estilos -->
<style>
/* Ocultamos todos los matches por defecto */
.match {
	display: none;
}
</style>

<!-- Scripts -->

<!-- Importamos jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
// al inicio del programa
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

<body>
<pre>

<!-- Imprimimos el HTML generado con PHP -->
<?php load_xml($path_xml); ?>

</pre>
</body>