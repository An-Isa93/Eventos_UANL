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
    $sql="SELECT*FROM Persona";
    $resultado=mysqli_query($conexion,$sql);
  ?>

    <h1>Personas</h1>
    <a href="">Agregar nueva Persona</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
             
            </tr>
        </thead>
        <tbody>
            <?php
               while($filas=mysqli_fetch_assoc($resultado)){
            ?>
            <tr>
                <td><?php echo $filas['Nombre']?></td>
                <td><?php echo $filas['Apellido_paterno']?></td>
                <td><?php echo $filas['Apellido_materno']?></td>
                <td><?php echo $filas['Correo']?></td>
            </tr>
            <?php }?>
            <?php echo "<a href=''>Editar</a>"; ?>
        </tbody>
    </table>
</body>
</html>