<?php

class Alumno extends Controller
{

    function __construct()
    {

        parent::__construct();
    }

    function render()
    {
        //Cambio la propiedad title de la vista
        $this->view->title = "Home - Panel Control Alumnos";

        //Creamos la variable alumnos dentro de la vista
        //Esta variable ejecuta el método get() del modelo alumnoModel
        $this->view->alumnos = $this->model->get();

        $this->view->render('alumno/main/index');
    }

    function new(){

        //Cambio la propiedad title de la vista
        $this->view->title = "Añadir - Gestión Alumnos";

        //Cargo los cursos para generar dinámicamente lista de cursos
        $this->view->cursos = $this->model->getCursos();

        $this->view->render('alumno/new/index');
    }

    function create($param = []){

        //Cargamos los datos del formulario para crear el nuevo alumno
        $alumno = new classAlumno(
            null,
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['email'],
            $_POST['telefono'],
            null,
            $_POST['poblacion'],
            null,
            null,
            $_POST['dni'],
            $_POST['fechaNac'],
            $_POST['id_curso']
        );

        //Validación (no la haremos)

        //Añadir registro a la tabla
        $this->model->create($alumno);

        //Redigirimos a "alumno"
        header("Location: ".URL."alumno");
    }
}
