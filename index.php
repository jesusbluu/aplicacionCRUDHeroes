<?php require("class.View.php");?> <!-- Llamando a la vista -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<title>CRUD</title>
	<meta name="description" content="Aplicación CRUD (Create-Read-Update-Delete) con filosofia MVC desarrollada en PHP MySQL y AJAX"" />
	<link rel="stylesheet" href="estilos/css/estilos.css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Quicksand:700' rel='stylesheet' type='text/css'>
</head>
<body>
	<header>
		<h1 id="logo">
			Super Héroes
		</h1>
	</header>
	<div id="logo-banner"></div>
	<div>
		<a href="#" id="insertar" class="insertar-class">Insertar</a>
	</div>
	<div id="precarga"></div>
	<div id="respuesta"></div>
	<article>
		<section>
			<div>
				<?php $html = new generaHTML(); 
				$html->mostrarHeroes(); ?>
			</div>
		</section>
	</article>
	<footer>
		<div>
			<p>
				Aplicación CRUD
			</p>
		</div>
	</footer>
	<script src="js/ajax.js"></script> <!-- Despachador Ajax -->
</body>
</html>