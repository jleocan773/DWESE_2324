<?php

class Alumno extends Controller
{

    function __construct()
    {

        parent::__construct();
    }

    function render()
    {

        # Inicio o continúo la sesión
        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # Comprobar si existe el mensaje
            if (isset($_SESSION['mensaje'])) {
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            # Creo la propiedad title de la vista
            $this->view->title = "Home - Panel Control Alumnos";

            # Creo la propiedad alumnos dentro de la vista
            # Del modelo asignado al controlador ejecuto el método get();
            $this->view->alumnos = $this->model->get();

            $this->view->render('alumno/main/index');
        }
    }
    function new()
    {

        # Iniciar o continuar sesión
        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # Crear un objeto alumno vacío
            $this->view->alumno = new classAlumno();

            # Comprobar si vuelvo de un registro no validado
            if (isset($_SESSION['error'])) {

                # Mensaje de error
                $this->view->error = $_SESSION['error'];


                # Autorrellenar el formulario con los detalles del alumno
                $this->view->alumno = unserialize($_SESSION['alumno']);

                # Recupero array de errores específicos
                $this->view->errores = $_SESSION['errores'];

                unset($_SESSION['error']);
                unset($_SESSION['errores']);
                unset($_SESSION['alumno']);
            }

            # etiqueta title de la vista
            $this->view->title = "Añadir - Gestión Alumnos";

            #  obtener los cursos  para generar dinámicamente lista cursos
            $this->view->cursos = $this->model->getCursos();

            # cargo la vista con el formulario nuevo alumno
            $this->view->render('alumno/new/index');
        }
    }

    function create($param = [])
    {

        # Iniciar sesión

        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # 1. Seguridad. Saneamos los datos del formulario
            // $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);

            # Si se introduce un nombre vacío, se le otorga "nulo"
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $apellidos = filter_var($_POST['apellidos'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            $telefono = filter_var($_POST['telefono'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $poblacion = filter_var($_POST['poblacion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $dni = filter_var($_POST['dni'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fechaNac = filter_var($_POST['fechaNac'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_curso = filter_var($_POST['id_curso'] ??= '', FILTER_SANITIZE_NUMBER_INT);


            # 2. Creamos el alumno con los datos saneados
            # Cargamos los datos del formulario
            $alumno = new classAlumno(
                null,
                $nombre,
                $apellidos,
                $email,
                $telefono,
                null,
                $poblacion,
                null,
                null,
                $dni,
                $fechaNac,
                $id_curso
            );

            # 3. Validación
            $errores = [];

            // Nombre: Obligatorio
            if (empty($nombre)) {
                $errores['nombre'] = 'El campo nombre es obligatorio';
            }

            // Apellidos: Obligatorio
            if (empty($apellidos)) {
                $errores['apellidos'] = 'El campo apellidos es obligatorio';
            }

            // Email: Obligatorio
            if (empty($email)) {
                $errores['email'] = 'El campo email es obligatorio';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'Formato email incorrecto';
            } else if (!$this->model->validateEmail($email)) {
                $errores['email'] = 'El email ya existe';
            }

            // Teléfono: Obligatorio
            if (empty($telefono)) {
                $errores['telefono'] = 'El campo telefono es obligatorio';
            }

            // Población: Obligatorio
            if (empty($poblacion)) {
                $errores['poblacion'] = 'El campo poblacion es obligatorio';
            }

            // DNI: Obligatorio
            $options = [
                'options' => [
                    'regexp' => '/^(\d{8})([A-Z])$/'
                ]
            ];

            if (empty($dni)) {
                $errores['dni'] = 'El campo dni es obligatorio';
            } else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $options)) {
                $errores['dni'] = 'Formato de DNI incorrecto';
            } else if (!$this->model->validateDNI($dni)) {
                $errores['dni'] = 'El dni ya existe';
            }

            // Fecha nacimiento: Obligatorio
            // $valores = explode('/', $fechaNac);
            // if (empty($fechaNac)) {
            //     $errores['fechaNac'] = 'El campo fecha de nacimiento es obligatorio';
            // } else if (!checkdate($valores[1], $valores[0], $valores[2])) {
            //     $errores['fechaNac'] = 'Formato de fecha de nacimiento erróneo';
            // }

            // ID Curso: Obligatorio, entero, existente
            if (empty($id_curso)) {
                $errores['id_curso'] = 'Debe seleccionar un curso';
            } else if (!filter_var($id_curso, FILTER_VALIDATE_INT)) {
                $errores['id_curso'] = 'Curso no válido';
            } else if (!$this->model->validateIdCurso($id_curso)) {
                $errores['id_curso'] = 'Curso no válido';
            }


            # 4. Comprobar validación
            if (!empty($errores)) {
                // Errores de validación
                // transforma el objeto alumno en un string
                $_SESSION['alumno'] = serialize($alumno);
                $_SESSION['error'] = 'Formulario no validado';
                $_SESSION['errores'] = $errores;

                # Redireccionamos a new
                header('Location:' . URL . 'alumno/new');
            } else {
                # Añadir registro a la tabla
                $this->model->create($alumno);

                # Mensaje
                $_SESSION['mensaje'] = "Alumno creado correctamente";

                # Redirigimos al main de alumnos
                header('location:' . URL . 'alumno');
            }
        }
    }

    function edit($param = [])
    {

        # Iniciar o continuar sesión
        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # obtengo el id del alumno que voy a editar
            // alumno/edit/4

            $id = $param[0];

            # asigno id a una propiedad de la vista
            $this->view->id = $id;

            # title
            $this->view->title = "Editar - Panel de control Alumnos";

            # obtener objeto de la clase alumno
            $this->view->alumno = $this->model->read($id);

            # obtener los cursos
            $this->view->cursos = $this->model->getCursos();

            //Comprobar si el formulario viene de una validación
            # Comprobar si vuelvo de un registro no validado
            if (isset($_SESSION['error'])) {

                # Mensaje de error
                $this->view->error = $_SESSION['error'];


                # Autorrellenar el formulario con los detalles del alumno
                $this->view->alumno = unserialize($_SESSION['alumno']);

                # Recupero array de errores específicos
                $this->view->errores = $_SESSION['errores'];

                unset($_SESSION['error']);
                unset($_SESSION['errores']);
                unset($_SESSION['alumno']);
            }

            # cargo la vista
            $this->view->render('alumno/edit/index');
        }
    }

    public function update($param = [])
    {

        # Iniciar o continuar sesión
        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # 1. Seguridad. Saneamos los datos del formulario
            // $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);

            # Si se introduce un nombre vacío, se le otorga "nulo"
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $apellidos = filter_var($_POST['apellidos'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            $telefono = filter_var($_POST['telefono'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $poblacion = filter_var($_POST['poblacion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $dni = filter_var($_POST['dni'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fechaNac = filter_var($_POST['fechaNac'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_curso = filter_var($_POST['id_curso'] ??= '', FILTER_SANITIZE_NUMBER_INT);

            # 2. Creamos el alumno con los datos saneados
            # Cargamos los datos del formulario
            $alumno = new classAlumno(
                null,
                $nombre,
                $apellidos,
                $email,
                $telefono,
                null,
                $poblacion,
                null,
                null,
                $dni,
                $fechaNac,
                $id_curso
            );

            # Cargo id del alumno
            $id = $param[0];

            //Obtengo el objeto alumno original
            $alumno_orig = $this->model->read($id);

            # 3. Validación
            $errores = [];

            // Nombre: Obligatorio
            if (strcmp($alumno->nombre, $alumno_orig->nombre) !== 0) {
                if (empty($apellidos)) {
                    $errores['apellidos'] = 'El campo apellidos es obligatorio';
                }
            }

            // Email: Obligatorio
            if (strcmp($alumno->apellidos, $alumno_orig->apellidos) !== 0) {
                if (empty($email)) {
                    $errores['email'] = 'El campo email es obligatorio';
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errores['email'] = 'Formato email incorrecto';
                } else if (!$this->model->validateEmail($email)) {
                    $errores['email'] = 'El email ya existe';
                }
            }

            // Teléfono: Obligatorio
            if (strcmp($alumno->telefono, $alumno_orig->telefono) !== 0) {

                if (empty($telefono)) {
                    $errores['telefono'] = 'El campo telefono es obligatorio';
                }
            }

            // Población: Obligatorio
            if (strcmp($alumno->poblacion, $alumno_orig->poblacion) !== 0) {
                if (empty($poblacion)) {
                    $errores['poblacion'] = 'El campo poblacion es obligatorio';
                }
            }

            // DNI: Obligatorio
            if (strcmp($alumno->dni, $alumno_orig->dni) !== 0) {
                $options = [
                    'options' => [
                        'regexp' => '/^(\d{8})([A-Z])$/'
                    ]
                ];

                if (empty($dni)) {
                    $errores['dni'] = 'El campo dni es obligatorio';
                } else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $options)) {
                    $errores['dni'] = 'Formato de DNI incorrecto';
                } else if (!$this->model->validateDNI($dni)) {
                    $errores['dni'] = 'El dni ya existe';
                }
            }

            // ID Curso: Obligatorio, entero, existente
            if (strcmp($alumno->dni, $alumno_orig->dni) !== 0) {
                if (empty($id_curso)) {
                    $errores['id_curso'] = 'Debe seleccionar un curso';
                } else if (!filter_var($id_curso, FILTER_VALIDATE_INT)) {
                    $errores['id_curso'] = 'Curso no válido';
                } else if (!$this->model->validateIdCurso($id_curso)) {
                    $errores['id_curso'] = 'Curso no válido';
                }
            }

            # 4. Comprobar validación
            if (!empty($errores)) {
                // Errores de validación
                // transforma el objeto alumno en un string
                $_SESSION['alumno'] = serialize($alumno);
                $_SESSION['error'] = 'Formulario no validado';
                $_SESSION['errores'] = $errores;

                # Redireccionamos a new
                header('Location:' . URL . 'alumno/edit/' . $id);
            } else {
                # Añadir registro a la tabla
                $this->model->update($alumno, $id);

                # Mensaje
                $_SESSION['mensaje'] = "Alumno editado correctamente";

                # Redirigimos al main de alumnos
                header('Location:' . URL . 'alumno');
            }
        }
    }



    public function order($param = [])
    {

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # Obtengo criterio de ordenación
            $criterio = $param[0];

            # Creo la propiedad title de la vista
            $this->view->title = "Ordenar - Panel Control Alumnos";

            # Creo la propiedad alumnos dentro de la vista
            # Del modelo asignado al controlador ejecuto el método get();
            $this->view->alumnos = $this->model->order($criterio);

            # Cargo la vista principal de alumno
            $this->view->render('alumno/main/index');
        }
    }

    public function filter($param = [])
    {

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            # Obtengo expresión de búsqueda
            $expresion = $_GET['expresion'];

            # Creo la propiedad title de la vista
            $this->view->title = "Buscar - Panel Control Alumnos";

            # Filtro a partir de la  expresión
            $this->view->alumnos = $this->model->filter($expresion);

            # Cargo la vista principal de alumno
            $this->view->render('alumno/main/index');
        }
    }
    public function delete($param = [])
    {

        # Inicio o continúo la sesión
        session_start();

        //Comprobar si el usuario está identificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario No Autentificado";

            header("location:" . URL . "login");
        } else {

            //Obteneemos id del alumno

            $id->$param[0];

            //Eliminamos el alumno
            $this->model->delete($id);

            //Generar mensasje
            $_SESSION['notify'] = 'Alumno borrado correctamente';

            //Redirección
            header('location: ' . URL . 'alumno');
        }
    }
}
