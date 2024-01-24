<!DOCTYPE html>
<html lang="es">

<head>
    <!-- head -->
    <?php require_once("template/partials/head.php");  ?>
    <title>Clientes - Gesbank</title>
</head>

<body>
    <div class="container" style="padding-top: 2%;">
        <!-- menu fijo superior -->
        <?php require_once "template/partials/menuAut.php"; ?>
        <br><br>

        <!-- cabecera  -->
        <?php include "views/clientes/partials/header.php" ?>

        <!-- Mensaje de Error -->
        <?php include 'template/partials/mensaje.php' ?>

        <!-- Menu principal -->
        <?php require_once "views/clientes/partials/menu.php" ?>

        <!-- tabla clientes -->
        <table class="table">
            <thead>
                <tr>
                    <th>Id </th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Ciudad</th>
                    <th>DNI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->clientes as $cliente) : ?>
                    <tr>
                        <td><?= $cliente->id ?></td>
                        <td><?= $cliente->cliente ?></td>
                        <td><?= $cliente->email ?></td>
                        <td><?= $cliente->telefono ?></td>
                        <td><?= $cliente->ciudad ?></td>
                        <td><?= $cliente->dni ?></td>
                        
                        <!-- botones de acción -->
                        <td>
                            <!-- botón  eliminar -->
                            <a href="<?= URL ?>clientes/delete/<?= $cliente->id ?>" title="Eliminar" onclick="return confirm('Confirmar eliminación del Cliente')" <?= (!in_array($_SESSION['id_rol'], $GLOBALS['clientes']['delete'])) ?
                                                                                                                                                                        'class="btn disabled"' : null ?>>
                                <i class="bi bi-trash-fill"></i></a>

                            <!-- botón  editar -->
                            <a href="<?= URL ?>clientes/editar/<?= $cliente->id ?>" title="Editar" <?= (!in_array($_SESSION['id_rol'], $GLOBALS['clientes']['editar'])) ?
                                                                                                        'class="btn disabled"' : null ?>>
                                <i class="bi bi-pencil-square"></i></a>

                            <!-- botón  mostrar -->
                            <a href="<?= URL ?>clientes/mostrar/<?= $cliente->id ?> ?>" title="Mostrar" <?= (!in_array($_SESSION['id_rol'], $GLOBALS['clientes']['mostrar'])) ?
                                                                                                            'class="btn disabled"' : null ?>>
                                <i class="bi bi-card-text"></i></a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">Nº Registros: <?= $this->clientes->rowCount() ?> </td>
                </tr>
            </tfoot>

        </table>

    </div>

    <!-- footer -->
    <?php require_once "template/partials/footer.php" ?>

    <!-- Bootstrap JS y popper -->
    <?php require_once "template/partials/javascript.php" ?>
</body>

</html>