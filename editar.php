<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Eventos</title>
</head>
<body>

    <?php
        include("conexion.php");

         // Cargar dependencias
    $sqlDependencias = "CALL SelectDependencia()";
    $resultadoDependencias = mysqli_query($conexion, $sqlDependencias);

    //liberar el resultado de la consulta
    $dependencias = [];
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

        if (isset($_POST['enviar'])) {
            $cv_evento = $_POST['cv_evento'];
            $nombre = $_POST['nombre'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $temario = $_POST['temario'];
            $sede = $_POST['sede'];
            $categoria = $_POST['categoria'];
            $dependencia = $_POST['dependencia'];
            $costo = $_POST['costo'];

        
            // Prepara la consulta
            $sql = "CALL UpdateEvento(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Inicializa la declaración
            $stmt = mysqli_prepare($conexion, $sql);

            // Verifica si la declaración se preparó correctamente
            if ($stmt) {
                // Une los parámetros a la declaración preparada
                mysqli_stmt_bind_param($stmt, "issssbiiii", $cv_evento, $nombre, $fecha, $hora, $temario, $sede, $categoria, $dependencia, $costo);

                // Ejecuta la declaración
                mysqli_stmt_execute($stmt);

                // Cierra la declaración
                mysqli_stmt_close($stmt);

                echo "<script language='Javascript'>
                alert('Datos actualizados correctamente');
                location.assign('index.php');
                </script>";
            } else {
                echo "<script language='Javascript'>
                alert('No se actualizaron correctamente');
                location.assign('index.php');
                </script>";
            }

            // Cierra la conexión
            mysqli_close($conexion);

        } else {
            if (isset($_GET['cv_evento'])) {
                $cv_evento = $_GET['cv_evento'];
                $sql = "CALL BuscarEvento(?)";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "i", $cv_evento);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);

                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $nombre = $fila['Nombre_Evento'];
                    $fecha = $fila['Fecha'];
                    $hora = $fila['Hora'];
                    $temario = $fila['Temario'];
                    $sede = $fila['Nombre_Sede'];
                    $categoria = $fila['Nombre_Categoria'];
                    $dependencia = $fila['Nombre_Dependencia'];
                    $costo = $fila['Costo'];
                } else {
                    echo "No se encontró el evento.";
                }
                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
            } else {
                echo "ID de evento no proporcionado.";
            }
    ?>

    <h1>Editar Evento</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cv_evento" value="<?php echo $cv_evento; ?>">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br>

        <label>Fecha</label>
        <input type="date" name="fecha" value="<?php echo $fecha; ?>" required><br>

        <label>Hora</label>
        <input type="time" name="hora" value="<?php echo $hora; ?>" required><br>

        <label>Temario</label>
        <textarea name="temario" required><?php echo $temario; ?></textarea><br>

        <label>Sede</label>
        <select name="cv_sede" required>
            <?php foreach ($sedes as $fila) { ?>
                <option value="<?php echo $fila['cv_sede']; ?>" <?php echo ($fila['Nombre'] == $sede) ? 'selected' : ''; ?>>
                    <?php echo $fila['Nombre']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Categoria</label>
        <select name="cv_categoria" required>
            <?php foreach ($categorias as $fila) { ?>
                <option value="<?php echo $fila['cv_categoria']; ?>" <?php echo ($fila['Nombre'] == $categoria) ? 'selected' : ''; ?>>
                    <?php echo $fila['Nombre']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Dependencia</label>
        <select name="cv_dependencia" required>
            <?php foreach ($dependencias as $fila) { ?>
                <option value="<?php echo $fila['cv_dependecia']; ?>" <?php echo ($fila['Nombre'] == $dependencia) ? 'selected' : ''; ?>>
                    <?php echo $fila['Nombre']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Costo</label>
        <select name="cv_costo" required>
            <?php foreach ($costos as $fila) { ?>
                <option value="<?php echo $fila['cv_costo']; ?>" <?php echo ($fila['Descripcion'] == $costo) ? 'selected' : ''; ?>>
                    <?php echo $fila['Descripcion']; ?>
                </option>
            <?php } ?>
        </select><br>

        <input type="submit" name="enviar" value="Actualizar Evento">
        <a href="index.php">Regresar</a>
    </form>
    <?php 
        }
    ?>
</body>
</html>
