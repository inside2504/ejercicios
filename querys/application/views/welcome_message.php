<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Querys</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>

<div class="container">
	<h2>Ejercicio de querys</h2>
	<form>
		<table class="table">
			<tr>
				<th class="text-center">User_id</th>
				<th class="text-center">Fixture_id</th>
				<th class="text-center">Pick</th>
				<th class="text-center">Score_home</th>
				<th class="text-center">Score_away</th>
				<th class="text-center">Resultado</th>
			</tr>

			<?php foreach ($results as $row): 
			//Se hace uso de la variable $data con el arreglo para mostrar el contenido de los campos de las tablas
			?>
			<tr>
		        <td class="text-center"><?php echo $row->user_id?></td>
		        <td class="text-center"><?php echo $row->fixture_id ?></td>
		        <td class="text-center"><?php echo $row->pick ?></td>
		        <td class="text-center"><?php echo $row->score_home ?></td>
		        <td class="text-center"><?php echo $row->score_away ?></td>
		     <?php
		     	//Se realiza la comprobación de los datos contenidos en score_home y score_away para establecer el resultado
		     	//Si el score_home es mayor que score_away entonces el resultado en pantalla será "Local"
		     	//En otros casos, es decir que score_home sea menor o igual a score_away el resultado en pantalla será "Visitante"
		     	if ($row->score_home > $row->score_away) {
		     		echo "<td class='text-center'>"."Local"."</td>";
		     	} else{
		     		echo "<td class='text-center'>"."Visitante"."</td>";
		     	}

		     ?>
		    </tr>
		    <?php endforeach;?>
		</table>
	</form>
</div>

</body>
</html>