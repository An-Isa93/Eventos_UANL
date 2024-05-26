<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
<?php
 include("conexion.php");
     if(isset($_POST['enviar'])){
        if(empty($_POST['correo']) || empty($_POST['contraseña']))
        {
            echo "<script language='Javascript'>
            alert('Ingresar datos');
            location.assign('login.php');
            </script>";

        }else{
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];
            $correo = mysqli_real_escape_string($conexion, $correo);
            $contraseña = mysqli_real_escape_string($conexion, $contraseña);

        $sql = "CALL Login('$correo', '$contraseña')";
        $resultado = mysqli_query($conexion, $sql);
       
            if($fila=mysqli_fetch_assoc($resultado)){
                echo "<script language='Javascript'>
                alert('Bienvenido');
                location.assign('index.php');
                </script>";
            }else{
                echo "<script language='Javascript'>
                alert('Usuario o contraseña incorrectas');
                location.assign('login.php');
                </script>";

            }
        }
     }else{
?>
    <h1>Ingresar</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <div class="container">
           <label>Correo</label>
           <input type="email" name="correo">
           <label>Contraseña</label>
           <input  type="password" name="contraseña">
           <div class="login" name="contraseña">
           <a href="registro.php">¿Aun no tienes cuenta? Registrate</a>
           <br><br>
           <button  type="submit" name="enviar">Ingresar</button>
           </div>
       </div>
    </form>
<?php
   }
?>
     
</body>
</html>