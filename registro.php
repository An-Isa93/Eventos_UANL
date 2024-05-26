<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

<?php
    include("conexion.php");
    $sqlDependencias = "CALL SelectDependencia()";
    $resultadoDependencias = mysqli_query($conexion, $sqlDependencias);
    $dependencias= [];
    while($fila= mysqli_fetch_assoc($resultadoDependencias)){
        $dependencias[] = $fila;
    }
    mysqli_free_result($resultadoDependencias);
    mysqli_next_result($conexion);

    $sqlRoles = "CALL SelectRol()";
    $resultadoRoles = mysqli_query($conexion, $sqlRoles);
    $roles= [];
    while($fila= mysqli_fetch_assoc($resultadoRoles)){
        $roles[] = $fila;
    }
    mysqli_free_result($resultadoRoles);
    mysqli_next_result($conexion);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $cv_rol = $_POST['cv_rol'];
        $cv_dependencia = $_POST['cv_dependencia'];
   

        $sqlInsert = "CALL Registro('$nombre', '$apellido_paterno', '$apellido_materno', '$correo', '$contraseña', $cv_rol, $cv_dependencia)";
        
        if (mysqli_query($conexion, $sqlInsert)) {
            echo "<script language='Javascript'>
            alert('Usuario registrado correctamente');
            location.assign('login.php');
            </script>";

        } else {
            echo "Error: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    }



?>
<h1>Registrar nuevo usuario</h1>
<div class="container">
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        
           <label>Nombre</label>
           <input type="text" name="nombre">
           <label>Apellido Paterno</label>
           <input type="text" name="apellido_paterno">
           <label>Apellido Materno</label>
           <input type="text" name="apellido_materno">
           <label>Correo</label>
           <input type="email" name="correo">
           <label>Contraseña</label>
           <input type="text" name="contraseña">
           <label>Rol</label>
        <select name="cv_rol" required>
            <?php foreach ($roles as $fila) { ?>
                <option value="<?php echo $fila['cv_rol']; ?>"><?php echo ($fila['Rol']); ?></option>
            <?php } ?>
        </select>
        <label>Dependencia</label>
        <select name="cv_dependencia" required>
            <?php foreach ($dependencias as $fila) { ?>
                <option value="<?php echo $fila['cv_dependecia']; ?>"><?php echo ($fila['Nombre']); ?></option>
            <?php } ?>
        </select>
        <div class="login">
           <button  type="submit" name="enviar">Registrar</button>
        </div>
      </div>
    </div>
    </form>
</body>
</html>