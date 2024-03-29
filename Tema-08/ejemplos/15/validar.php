<?php

/*
    Ejemplo de validacion  de  archivo subidos desde formulario
*/

//Iniciar sesión
session_start();



//Saneamiento de las variables
$nombre = filter_var($_POST['nombre'] ??= null, FILTER_SANITIZE_SPECIAL_CHARS);
$observaciones = filter_var($_POST['observaciones'] ??= null, FILTER_SANITIZE_SPECIAL_CHARS);

//Cargo el archivo
$fichero = $_FILES['fichero'];

//Genero un array de error de fichero
$fileUploadErrors = array(
    0 => 'El archivo se ha subido correctamente',
    1 => 'El archivo excede el tamaño permitido',
    2 => 'El archivo excede el tamaño permitido de la directiva MAX_FILE_SIZE',
    3 => 'El archivo se ha subido parcialmente',
    4 => 'No se ha subido ningun archivo',
    6 => 'Falta una carpeta temporal',
    7 => 'Error al escribir el archivo en disco',
    8 => 'PHP detuvo la subida del archivo',
);

//Validación
$errores = [];

if (($fichero['error']) !== UPLOAD_ERR_OK) {

    //Comprobar que error se ha producido
    if (is_null($fichero)) {
        $errores['fichero'] = $fileUploadErrors[1];
    } else {
        $errores['fichero'] = $fileUploadErrors[$fichero['error']];
    }
} else if (is_uploaded_file($fichero['tmp_name'])) {

    //Validar tamaño, máximo 2 mb
    $max_size = 2 * 1024 * 1024;

    if ($fichero['size'] > $max_size) {
        $errores['fichero'] = "El tamaño del archivo es demasiado grande";
    }

    //Validar tipo de archivo
    $info = new SplFileInfo($fichero['name']);
    $tipos_permitidos = ['JPG', 'JPEG', 'PNG', 'GIF'];

    if (in_array(strtoupper($info->getExtension()), $tipos_permitidos) === false) {
        $errores['fichero'] = "El tipo de archivo no está permitido, tipos permitidos: JPG, JPEG, PNG y GIF";
    }
}
//Si ha habido algún error, es decir, si $errores no está vacío
if (!empty($errores)) {

    //Creamos las variables de sesión
    $_SESSION['error'] = "Formulario no validado";
    $_SESSION['errores'] = $errores;

    //Autocompletar el formulario
    $_SESSION['nombreCompleto'] = $nombreCompleto;
    $_SESSION['observaciones'] = $observaciones;
    $_SESSION['fichero'] = $fichero;
} else {
    //De lo contrario, movemos el archivo a la carpeta del servidor desde la temporal
    move_uploaded_file($fichero['tmp_name'], 'files/' . $fichero['name']);

    //Genero mensaje de alerta
    $_SESSION['mensaje'] = "Archivo subido correctamente";
}


header('location: index.php');
