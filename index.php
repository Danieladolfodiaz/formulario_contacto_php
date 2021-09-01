<?php

$conexion=mysqli_connect('localhost','root','','contacto_formulario');


$errores = '';
$enviado = '';

// Comprobamos que el formulario haya sido enviado.
if (isset($_POST['submit'])) {
	$nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$mensaje = $_POST['mensaje'];
	$consulta = "INSERT INTO usuario(nombre,email,mensaje) VALUES('$nombre','$email','$mensaje')";
	$resultado=mysqli_query($conexion,$consulta);

// Comprobamos que el nombre no este vacio.
	if (!empty($nombre)) {
		// Saneamos el nombre para eliminar caracteres que no deberian estar.
		$nombre = trim($nombre);
		$nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
		// Comprobamos que el nombre despues de quitar los caracteres ilegales no este vacio.
		if ($nombre == "") {
			$errores.= 'Por favor ingresa un nombre.<br />';
		}
	} else {
		$errores.= 'Por favor ingresa un nombre.<br />';
	}

	if (!empty($email)) {
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		// Comprobamos que sea un email valido
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errores.= "Por favor ingresa un email valido.<br />";
		}
	} else {
		$errores.= 'Por favor ingresa un email.<br />';
	}


	if (!empty($mensaje)) {
		// Podemos sanear la cadena de texto con filter_var, pero queremos que en el mensaje los signos se conviertan en entidades HTML
		$mensaje = htmlspecialchars($mensaje);
		$mensaje = trim($mensaje);
		$mensaje = stripslashes($mensaje);
	} else {
		$errores.= 'Por favor ingresa el mensaje.<br />';
	}

// Comprobamos si hay errores, si no hay entonces enviamos.
	if (!$errores) {
		$enviar_a = 'danieladolfodiazarg@gmail.com';
		$asunto = 'Email enviado desde miPagina.com';
		$mensaje = "De: $nombre \n";
		$mensaje.= "email: $email \n";
		$mensaje.= 'Mensaje: ' . $_POST['mensaje'];

		// mail($enviar_a, $asunto, $mensaje);
		$enviado = 'true';
	}
}

require 'index.view.php';

?>
