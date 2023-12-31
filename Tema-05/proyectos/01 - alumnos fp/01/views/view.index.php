<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'views/layouts/head.html' ?>
    <title>Proyecto 5.1 - FP</title>
</head>

<body>
    <!-- Capa principal -->
    <div class="container">

        <!-- cabecera documento -->
        <?php include 'views/partials/header.php' ?>

        <legend>Tabla Alumnos</legend>

        <!-- Menu Principal -->
        <?php include 'views/partials/menu_prin.php' ?>

        <!-- Notificación -->
        <br>
        <?php include 'views/partials/notificacion.php' ?>
        <br>

        <!-- Muestra datos de la tabla -->
        <table class="table">
            <!-- Encabezado tabla -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Población</th>
                    <th>DNI</th>
                    <th>Edad</th>
                    <th>Curso</th>
                </tr>
            </thead>
            <!-- Mostramos cuerpo de la tabla -->
            <tbody>
                <?php foreach ($alumnosfp as $alumno) : ?>
                    <tr>
                        <!-- Mostrar datos de alumnos -->
                        <td><?= $alumno['id'] ?></td>
                        <td><?= $alumno['nombre'] ?></td>
                        <td><?= $alumno['email'] ?></td>
                        <td><?= $alumno['telefono'] ?></td>
                        <td><?= $alumno['poblacion'] ?></td>
                        <td><?= $alumno['dni'] ?></td>
                        <td><?= $alumno['edad'] ?></td>
                        <td><?= $alumno['curso'] ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">Nº Alumnos: <?= $alumnosfp->num_rows ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Pié del documento -->
        <?php include 'views/partials/footer.html' ?>

    </div>

    <!-- javascript bootstrap 532 -->
    <?php include 'views/layouts/javascript.html' ?>
</body>

</html>