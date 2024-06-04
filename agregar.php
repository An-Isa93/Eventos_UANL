<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Evento</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
  <?php
    include("conexion.php");

    // Cargar dependencias
    $sqlDependencias = "CALL SelectDependencia()";
    $resultadoDependencias = mysqli_query($conexion, $sqlDependencias);

    //liberar el resultado de la consulta
    $dependencias= [];
    while($fila= mysqli_fetch_assoc($resultadoDependencias)){
        $dependencias[] = $fila;
    }
    mysqli_free_result($resultadoDependencias);
    mysqli_next_result($conexion);

    // Cargar costos
    $sqlCostos = "CALL SelectCosto";
    $resultadoCostos = mysqli_query($conexion, $sqlCostos);

    //liberar el resultado de la consulta
    $costos = [];
    while($fila = mysqli_fetch_assoc($resultadoCostos)){
        $costos[] = $fila;
    }
    mysqli_free_result($resultadoCostos);
    mysqli_next_result($conexion);

    // Cargar categorías
    $sqlCategorias = "CALL SelectCategoria()";
    $resultadoCategorias = mysqli_query($conexion, $sqlCategorias);

  // Liberar el resultado de la consulta de categorías
    $categorias = [];
    while ($fila = mysqli_fetch_assoc($resultadoCategorias)) {
        $categorias[] = $fila;
    }
    mysqli_free_result($resultadoCategorias);
    mysqli_next_result($conexion);

    // Cargar sedes
    $sqlSedes = "CALL SelectSede()";
    $resultadoSedes = mysqli_query($conexion, $sqlSedes);
    // Liberar el resultado de la consulta de sedes
    $sedes = [];
    while ($fila = mysqli_fetch_assoc($resultadoSedes)) {
        $sedes[] = $fila;
    }
    mysqli_free_result($resultadoSedes);
    mysqli_next_result($conexion);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $temario = $_POST['temario'];
        $poster = NULL;  // Assuming no file upload handling for simplicity
        $cv_sede = $_POST['cv_sede'];
        $cv_categoria = $_POST['cv_categoria'];
        $cv_dependecia = $_POST['cv_dependecia'];
        $cv_costo = $_POST['cv_costo'];

        $sqlInsert = "CALL InsertEvento('$nombre', '$fecha', '$hora', '$temario', '$poster', $cv_sede,
         $cv_categoria, $cv_dependecia, $cv_costo)";
        
        if (mysqli_query($conexion, $sqlInsert)) {
            echo "<script language='Javascript'>
            alert('Evento agregado Correctamente');
            location.assign('index.php');
            </script>";

        } else {
            echo "No fue posible agregar el evento: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    }
  ?>

    <h1>Agregar Nuevo Evento</h1>
    <div class="container">
    <form action="" method="post">
        <label>Nombre</label>
        <input type="text" name="nombre" required><br>

        <label>Fecha</label>
        <input type="date" name="fecha" required><br>

        <label>Hora</label>
        <input type="time" name="hora" required><br>

        <label>Temario</label>
        <textarea name="temario" ></textarea><br>

       <label>Sede</label>
        <select name="cv_sede" required>
            <?php foreach ($sedes as $fila) { ?>
                <option value="<?php echo $fila['cv_sede']; ?>"><?php echo ($fila['Nombre']); ?></option>
            <?php } ?>
        </select><br>

        <label>Categoria</label>
        <select name="cv_categoria" required>
            <?php foreach ($categorias as $fila) { ?>
                <option value="<?php echo $fila['cv_categoria']; ?>"><?php echo ($fila['Nombre']); ?></option>
            <?php } ?>
        </select><br>

        <label>Dependencia</label>
        <select name="cv_dependecia" required>
            <?php foreach ($dependencias as $fila) { ?>
                <option value="<?php echo $fila['cv_dependecia']; ?>"><?php echo $fila['Nombre']; ?></option>
            <?php } ?>
        </select><br>

        <label>Costo</label>
        <select name="cv_costo" required>
            <?php foreach ($costos as $fila ) { ?>
                <option value="<?php echo $fila['cv_costo']; ?>"><?php echo $fila['Descripcion']; ?></option>
            <?php } ?>
        </select><br>

        <button type="submit">Agregar Evento</button>
        <a href="index.php">Regresar</a>
    </form>
    </div>
</body>
</html>
