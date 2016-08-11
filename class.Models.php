<?php  

require_once "class.Conexion.php"; # Llamando a la conexión

#Clase para editar actualizar y eliminar

class insertaEditaElimina {

	public function insertarNuevoHeroe ($nombre,$imagen,$descripcion,$editorial) { #funcion para insertar heroes

		$conexion = new Conexion(); #creando instancia a la base de datos
		$resultado = $conexion->query("INSERT INTO heroes(id_heroe,nombre,imagen,descripcion,editorial) VALUES (0,'$nombre','$imagen','$descripcion',$editorial)"); #query
           
           $operador = ($resultado) ? $respuesta = "<div class='exito' data-recargar><p>Se insertó con éxito el registro del Superhéroe: <b>$nombre</b><p></div>" : $respuesta = "<div class='error'>Ocurrió un error NO se insertó el registro del Superhéroe: <b>$nombre</b></div>"; #operador ternario 

		$conexion->cerrar($conexion); #cerrando conexion
		return printf($respuesta); #imprimiendo
		
	}

	public function eliminaHeroe ($id) { #funcion para eliminar heroes

		$conexion = new Conexion();
		$resultado = $conexion->query("DELETE FROM heroes WHERE id_heroe=$id");

		   $operador = ($resultado) ? $respuesta = "<div class='exito' data-recargar><p>Se eliminó con éxito el registro del Superhéroe con id: <b>$id</b><p></div>" : "<div class='error'>Ocurrió un error NO se eliminó el registro del Superhéroe con el id: <b>$id</b></div>";

		$conexion->cerrar($conexion);
		return printf($respuesta);

	}

	public function actualizarHeroe ($id_heroe,$nombre,$imagen,$descripcion,$editorial) { #funcion para actualizar heroes

		$conexion = new Conexion(); 
		$resultado = $conexion->query("UPDATE heroes SET nombre='$nombre', imagen='$imagen', descripcion='$descripcion', editorial=$editorial WHERE id_heroe=$id_heroe");

		   $operador = ($resultado) ? $respuesta = "<div class='exito' data-recargar>Se Actualizó con éxito el registro del Superhéroe: <b>$nombre</b></div>" : "<div class='error'>Ocurrió un error NO se Actualizó el registro del Superhéroe: <b>$nombre</b></div>";

		$conexion->cerrar($conexion);
		return printf($respuesta);

	}

	
}

?>