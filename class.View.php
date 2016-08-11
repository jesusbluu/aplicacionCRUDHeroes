<?php
 #Llamando la Conexión a la Base de Datos
require_once "class.Conexion.php";

# Clase para generar la vista en el index
class generaHTML {

	public function mostrarHeroes () { #Funcion para mostrar la lista de los heroes
        
        $editorial = $this->catalogoEditoriales();
        $conexion = new Conexion();
        $sql = "SELECT * FROM heroes ORDER BY id_heroe DESC"; #Selecionar todo de heroes y ordenar por el id
            if ($resultado = $conexion->query($sql)) {

            	    $totalRegistros = $conexion->rows($resultado);
            	    if ($totalRegistros == 0) { #Si no existen heroes en la base de datos muestra
            	    	
            	    	$respuesta = "<div class='error'>No existe registros de Super Héroes . La Base de Datos esta vacía.</div>";

            	    } else { 
                    //Limitar mi consulta sql
                    $regXPAG = 3;
                    $pagina = false;

                       //Examinar la pagina a mostrar y el inicio del registro a mostrar
                       if (isset($_GET["p"])) {

                            $pagina = $_GET["p"];

                       } 

                       if (!$pagina) {

                            $inicio = 0;
                            $pagina = 1;

                       } else {

                            $inicio = ($pagina - 1) * $regXPAG;

                         } 

                    //Calculó el total de páginas
                    $totalPaginas = ceil($totalRegistros / $regXPAG);

                    $sql .= " LIMIT " . $inicio . "," . $regXPAG;
     
                    $resultado = $conexion->query($sql);

                   // Despliegue de la paginación

                    $paginacion = "<div class='paginacion'>";
                        $paginacion .= "<p>";
                          $paginacion .= "Número de resultados: <b>$totalRegistros</b>. ";
                          $paginacion .= "Mostrando <b>$regXPAG</b> resultados por página. ";
                          $paginacion .= "Página <b>$pagina</b> de <b>$totalPaginas</b>";
                        $paginacion .= "</p>";
                        if ($totalPaginas > 1) {

                              $paginacion .= "<p>";
                              $paginacion .= ($pagina != 1) ? "<a href='?p=" . ($pagina - 1) ."'>&laquo</a>" : "";
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                      #Si muestro el índice de la página actual, no coloco enlace
                                $actual = "<span class='actual'>$pagina</span>";
                      #Si  el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
                                $enlace = "<a href='?p=$i'>$i</a>";
                                $paginacion .= ($pagina == $i) ? $actual : $enlace;
                        }

                                $paginacion .= ($pagina != $totalPaginas) ? "<a href='?p=" . ($pagina + 1) ."'>&raquo</a>" : "";
                                $paginacion .= "</p>";

                        } 
                        http://localhost/CRUD/estilos/img/hulk.png
                    $paginacion .= "<div>";
            	    	$tabla = "<table id='tabla-heroes' class='tabla'>";
		                     $tabla .= "<thead>";
		                          $tabla .= "<tr>";
		                                    $tabla .= "<th>Id Héroe</th>";
		                                    $tabla .= "<th>Nombre</th>";
		                                    $tabla .= "<th>Imagen</th>";
		                                    $tabla .= "<th>Descripción</th>";
		                                    $tabla .= "<th>Editorial</th>";
		                                    $tabla .= "<th></th>";
		                                    $tabla .= "<th></th>";
		                          $tabla .= "</tr>";
		                     $tabla .= "</thead>";
		                $tabla .= "<tbody>";
		                    while ($fila = $conexion->assoc($resultado)) {

			                       $tabla .= "<tr>";
			                              $tabla .= "<td>" . $fila["id_heroe"] . "</td>";
			                              $tabla .= "<td><h2>" . $fila["nombre"] . "</h2></td>";
			                              $tabla .= "<td><img class='imagenes' src='estilos/img/" . $fila["imagen"] . "'/></td>";
			                              $tabla .= "<td><p>" . $fila["descripcion"] . "</p></td>";
			                              $tabla .= "<td><h3>" . $editorial[$fila["editorial"]] . "</h3></td>";
			                              $tabla .= "<td><a class='editar' href='#' data-id='" . $fila["id_heroe"] . "'>Editar</a></td>";
			                              $tabla .= "<td><a class='eliminar' href='#' data-id='" . $fila["id_heroe"] . "'>Eliminar</a></td>";
			                       $tabla .= "</tr>";

            	            }

                     $tabla .= "</tbody>";
                           $tabla .= "</table>";
                           $respuesta = $tabla . $paginacion;

                    }

          } else {

            $respuesta = "<div class='error'>Error: No se ejecuto la consulta a la Base de Datos</div>";

          }

          $conexion->liberar($resultado);
	        $conexion->cerrar($conexion);
	        return printf($respuesta);

    }

    public function catalogoEditoriales () {

    	$editoriales = Array();
    	$conexion = new Conexion();
    	$sql = "SELECT * FROM editorial";

    	   if ($resultado = $conexion->query($sql)) {
    	   	   
    	   	   while ($fila = $conexion->assoc($resultado)) {
    	   	   	  
    	   	   	  $editoriales[$fila["id_editorial"]] = $fila["editorial"];

    	   	   }
    	   	   $conexion->liberar($resultado);

    	   }
    	   $conexion->cerrar($conexion);
    	   return $editoriales;

    }

    public function insertarHeroe () {
        
        $form = "<form id='alta-heroe' class='formulario' data-insertar>";
        $form .= "<fieldset>";
            $form .= "<legend>Insertar Super Héroe:</legend>";
            $form .= "<div>";
                $form .= "<label for='nombre'>Nombre</label><br />";
                $form .= "<input type='text' id='nombre' name='nombre_txt' required />";
            $form .= "</div>";
            $form .= "<div>";
                $form .= "<label for='imagen'>Imagen:</label><br />";
                $form .= "<input type='text' id='imagen' name='imagen_txt' required />";
            $form .= "</div>";
            $form .= "<div>";
                $form .= "<label for='descripcion'>Descripción:</label><br />";
                $form .= "<textarea cols='60' rows='10' id='descripcion' name='descripcion_txa' required></textarea>";
            $form .= "</div>";
            $form .= "<div>";
                $form .= "<label for='editoral'>Editoral:</label>";
                $form .= $this->listaEditoriales();
            $form .= "</div>";    
            $form .= "<div>";
                $form .= "<input type='submit' data-botones id='insertar-btn' class='insertar-class' name='insertar_btn' value='Insertar'/>";
                $form .= "<input type='hidden' id='transaccion' name='transaccion' value='insertar' />";
            $form .= "<input type='button' data-botones class='cancelar' onclick='cancelarHeroe();' value='Cancelar' />";
            $form .= "</div>";
        $form .= "</fieldset>";  
        $form .= "</form>";

        return printf($form);

    }

    public function listaEditoriales () {

        $conexion = new Conexion();
        $sql = "SELECT * FROM editorial";
        $resultado = $conexion->query($sql);
        $lista = "<select id='editorial' name='editorial_slc' required>";
              $lista .= "<option value=''>Selecciona Un Editorial</option>";
        while ($fila = $conexion->assoc($resultado)) {
            
            $lista .= sprintf("<option value='%d'>%s</option>",$fila["id_editorial"],$fila["editorial"]);

        }
        $lista .= "</select>";
        $conexion->liberar($resultado);
        $conexion->cerrar($conexion);
        return $lista;

    }

    public function editaHeroe ($idHeroe) {

        $conexion = new Conexion();
        $resultado = $conexion->query("SELECT * FROM heroes WHERE id_heroe=$idHeroe");

           if ($resultado) {
               
                  $fila = $conexion->assoc($resultado);

                      $form = "<form id='editar-heroe' class='formulario' data-editar>";
                          $form .= "<fieldset>";
                              $form .= "<legend>Edición de Super Héroe:</legend>";
                                  $form .= "<div>";
                                    $form .= "<label for='nombre'>Nombre</label><br />";
                                      $form .= "<input type='text' id='nombre' name='nombre_txt' value='". $fila["nombre"] ."' required />";
                                  $form .= "</div>";
                                  $form .= "<div>";
                                    $form .= "<label for='imagen'>Imagen:<br /></label>";
                                    $form .= "<input type='text' id='imagen' value='" . $fila["imagen"] ."' name='imagen_txt' required />";
                                  $form .= "</div>";
                                  $form .= "<div>";
                                    $form .= "<label for='descripcion'>Descripción:<br /></label>";
                                    $form .= "<textarea cols='60' rows='10' id='descripcion' name='descripcion_txa' required>" . $fila["descripcion"] ."</textarea>";
                                  $form .= "</div>";
                                  $form .= "<div>";
                                    $form .= "<label for='editoral'>Editoral:</label>";
                                   $form .= $this->listaEditorialesEditada($fila["editorial"]);
                                  $form .= "</div><br />";    
                                  $form .= "<div>";
                                    $form .= "<input type='submit' class='editar' id='actualizar-btn' name='actualizar_btn'  value='Actualizar' />";
                                    $form .= "<input type='hidden' id='transaccion' name='transaccion' value='actualizar' />";
                                    $form .= "<input type='hidden' id='idHeroe' name='idHeroe' value='" . $fila["id_heroe"] . "' />";
                                  $form .= "</div>";
                          $form .= "</fieldset>";  
                      $form .= "</form>";
        
        $conexion->liberar($resultado);

           } else {

               $form = "<div class='error'>Error: No se ejecuto la consulta a la Base de Datos</div>";

           }
           $conexion->cerrar($conexion);

           return printf($form);

    }

    public function listaEditorialesEditada ($id) {

        $conexion = new Conexion();
        $resultado = $conexion->query("SELECT * FROM editorial");

        $lista = "<select id='editorial' name='editorial_slc' required>";
            $lista .= "<option value=''>- - -</option>";
        while ($fila = $conexion->assoc($resultado)) {
            
               $selected = ($id == $fila["id_editorial"]) ? "selected" : "";

               $lista .= sprintf(
                        "<option value='%d' $selected>%s</option>", $fila["id_editorial"], 
                        $fila["editorial"]);


        }

        $lista .= "</select>";
        $conexion->liberar($resultado);
        $conexion->cerrar($conexion);

        return $lista;

    }


}


?>