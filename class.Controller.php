<?php  
#echo "<p>Llamando al controlador desde el ajax</p><br/><img src='estilos/img/gb.gif' />";
require "class.View.php";
require "class.Models.php";

$transaccion = $_POST["transaccion"];


function ejecutarTransaccion ($transaccion) {

	if ($transaccion == "alta") {

		$html = new generaHTML();
		$html->insertarHeroe();

	} else if ($transaccion == "insertar") {
        
        $inserta = new insertaEditaElimina();
		$inserta->insertarNuevoHeroe($_POST["nombre_txt"],$_POST["imagen_txt"],$_POST["descripcion_txa"],$_POST["editorial_slc"]
	    );

	} else if ($transaccion == "eliminar") {
		
		$eliminar = new insertaEditaElimina();
		$eliminar->eliminaHeroe($_POST["idHeroe"]);

	} else if ($transaccion == "editar") {

		$editar = new generaHTML();
		$editar->editaHeroe($_POST["idHeroe"]);

	} else if ($transaccion == "actualizar") {
		
		$actualizar = new insertaEditaElimina();
		$actualizar->actualizarHeroe($_POST["idHeroe"],$_POST["nombre_txt"],$_POST["imagen_txt"],$_POST["descripcion_txa"],$_POST["editorial_slc"]);

	}

}

ejecutarTransaccion($transaccion);

?>