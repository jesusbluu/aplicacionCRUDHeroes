<?php 

require "core.php";

class Conexion extends mysqli { #Clase Conexíón que contiene las funciones de mysqli

	public function __construct () {
		
		parent::__construct(HOST,USER,PASS,DATABASE);
        $this->set_charset("utf8");

	}

	public function assoc($resultado) { #Obtener una fila de resultado como un array asociativo

        return mysqli_fetch_assoc($resultado);

    }

    public function liberar($query) { #Liberar la memoria del resultado

        return mysqli_free_result($query);

    }

    public function cerrar($conexion) { #Cerrar la Conexión 

    	return mysqli_close($conexion);

    }

    public function rows($query) {

    	return mysqli_num_rows($query);

    }

}


?>