<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
</head>
<body>
  <?php
    include("conexion.php");
    $sql = "CALL VerEventos()";
    $resultado = mysqli_query($conexion, $sql);
  ?>

    <h1>Eventos</h1>
    <a href="agregar.php">Agregar nuevo Evento</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Temario</th>
                <th>Sede</th>
                <th>Categoria</th>
                <th>Dependencia</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
               while ($filas = mysqli_fetch_assoc($resultado)) {
            ?>
            <tr>
                <td><?php echo $filas['Nombre_Evento']; ?></td>
                <td><?php echo $filas['Fecha']; ?></td>
                <td><?php echo $filas['Hora']; ?></td>
                <td><?php echo $filas['Temario']; ?></td>
                <td><?php echo $filas['Nombre_Sede']; ?></td>
                <td><?php echo $filas['Nombre_Categoria']; ?></td>
                <td><?php echo $filas['Nombre_Dependencia']; ?></td>
                <td><?php echo $filas['Costo']; ?></td>
                <td>
                  <a href='editar.php?cv_evento=<?php echo $filas['Id']; ?>'>Editar</a>
                </td>
                <td>
                <a href='eliminar.php?cv_evento=<?php echo $filas['Id']; ?>'>Eliminar</a>
               </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php
    mysqli_close($conexion);
?>
