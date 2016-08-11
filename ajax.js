//Constantes
var READY_STATE_COMPLETE = 4;
var OK = 200;


//Variables

var ajax = null;
var botonInsertar = document.querySelector("#insertar");
var precarga = document.querySelector("#precarga");
var respuesta = document.querySelector("#respuesta");
var botonEliminar = document.querySelectorAll(".eliminar");
var botonEditar = document.querySelectorAll(".editar");




//Funciones

function objetoAJAX () {

	if (window.XMLHttpRequest) {

		return new XMLHttpRequest();

	} else if (window.ActiveXObject) {

		return new ActiveXObject("Microsoft.XMLHTTP");

	}

}

function enviarDatos (evento) {

	precarga.style.display = "block";
	precarga.innerHTML = "<img src='estilos/img/loader.gif' />";

	  if (ajax.readyState == READY_STATE_COMPLETE) {

	  	  if (ajax.status == OK) {
            
	  	  	precarga.innerHTML = null;
            precarga.style.display = "none";
            respuesta.style.display = "block";
            respuesta.innerHTML = ajax.responseText;
            botonInsertar.style.display = "none";

               if (ajax.responseText.indexOf("data-insertar") > -1) {

               	   document.querySelector("#alta-heroe").addEventListener("submit",insertarActualizarHeroe);

               }

               if (ajax.responseText.indexOf("data-editar") > -1) {

            	    document.querySelector("#editar-heroe").addEventListener("submit", insertarActualizarHeroe);

                }

               if (ajax.responseText.indexOf("data-recargar") > -1) {

               	   setTimeout(window.location.reload(),3000);

               }

	  	  } else {
			
			alert("El servidor No contestó\nError "+ajax.status+": "+ajax.statusText);

		}

	  } 
}

function ejecutarAJAX (datos) {

	ajax = objetoAJAX();
	ajax.onreadystatechange = enviarDatos;
	ajax.open("POST","class.Controller.php");
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(datos);

} 

function insertarActualizarHeroe (evento) {
    
    evento.preventDefault();
	var nombre = new Array();
	var valor = new Array();
    var hijosForm = evento.target;
    var datos = "";

       for (var i = 1; i < hijosForm.length; i++) {

             nombre[i] = hijosForm[i].name;
       	     valor[i] = hijosForm[i].value;

       	     datos += nombre[i] + "=" + valor[i] + "&";
       	     console.log(datos);

       }

       ejecutarAJAX(datos);

}

function altaHeroe (evento) {
	
	evento.preventDefault();
	var datos = "transaccion=alta";
	ejecutarAJAX(datos);

}

function eliminarHeroe (evento) {

	evento.preventDefault();
	idHeroe = evento.target.dataset.id;
	var eliminar = confirm("¿Estás seguro de eliminar el Super Héroe con el id: "+idHeroe);

	   if (eliminar) {

	   	   var datos = "idHeroe="+idHeroe+"&transaccion=eliminar";
		   ejecutarAJAX(datos);

	   }

}

function editarHeroe (evento) {

	evento.preventDefault();
	var idHeroe = evento.target.dataset.id;
	var datos = "idHeroe=" + idHeroe + "&transaccion=editar";
	ejecutarAJAX(datos);

}

function cancelarHeroe (evento) {

	document.querySelector("#alta-heroe").style.display = "none";
	botonInsertar.style.display = "block";
	botonInsertar.style.width = "60px";
	botonInsertar.style.margin = "auto";


}

function cargaDocumento () {

	botonInsertar.addEventListener("click", altaHeroe);

	   for (var i = 0; i < botonEliminar.length; i++) {
	   	    
	   	    botonEliminar[i].addEventListener("click", eliminarHeroe);

	   }

	   for (var i = 0; i < botonEditar.length; i++) {
	   	    
	   	    botonEditar[i].addEventListener("click", editarHeroe);

	   }


}

//Eventos

window.addEventListener("load",cargaDocumento);