<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Plantilla Bootstrap 5.3.2</title>

	<!-- Bootstrap css -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

	<!-- Bootstrap Icons 1.11.1 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body>
	<!-- Capa Principal -->
	<div class="container">
		<header class="pb-3 mb-4 border-bottom">
			<i class="bi bi-rocket-takeoff-fill"></i>
			<span class="fs-3">Proyecto 2.2 - Lanzamiento de Proyectil</span>
			<i class="bi bi-rocket-takeoff-fill"></i>
		</header>

		<legend>Resultados</legend>
		<!-- Ángulo -->
		<table class="table">
			<tbody>
				<tr>
					<th>Valores Iniciales</th>
					<td></td>
				</tr>
				<tr>
					<td>Velocidad Inicial</td>
					<td><?=$velini?> m/s</td>
				</tr>
				<tr>
					<td>Ángulo</td>
					<td><?=$angulo?>º</td>
				</tr>
				<tr>
					<th>Resultados</th>
					<td></td>
				</tr>
				<tr>
					<td>Ángulos Radianes</td>
					<td><?=$anguloRadianes?>º</td>
				</tr>
				<tr>
					<td>Velocidad Inicial X</td>
					<td><?=$velinix?> m/s</td>
				</tr>
				<tr>
					<td>Velocidad Inicial Y</td>
					<td><?=$veliniy?> m/s</td>
				</tr>
				<tr>
					<td>Alcance Máximo Proyectil</td>
					<td><?=$alcancemaximo?> m/s</td>
				</tr>
				<tr>
					<td>Tiempo Vuelo Proyectil</td>
					<td><?=$tiempoproyectil?> m/s</td>
				</tr>
				<tr>
					<td>Altura Máxima Proyectil</td>
					<td><?=$alturamaxima?> m/s</td>
				</tr>
			</tbody>
		</table>


		<!-- Botón de volver a Index -->
		<div class="btn-group" role="group">
			<a class="btn btn-primary" href="index.php" role="button">Volver</a>
		</div>
	</div>

	</div>

	<!-- Pie del documento -->
	<footer class="footer mt-auto py-3 fixed-bottom bg-light">
		<div class="container">
			<span class="text-muted">
				© 2023 Jonathan Leon Canto - DWES - 2º DAW - Curso 23/24
			</span>
		</div>
	</footer>

	<!-- Bootstrap Javascript y popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>