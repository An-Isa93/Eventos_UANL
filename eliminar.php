<?php
 include("conexion.php");
 $cv_evento=$_GET['cv_evento'];
 $sql="CALL DeleteEvento($cv_evento)";
 $resultado=mysqli_query($conexion,$sql);
 if($resultado){
    echo "<script language='Javascript'>
    alert('Datos eliminados correctamente');
    location.assign('index.php');
    </script>";
    mysqli_close($conexion);
  } else {
    echo "<script language='Javascript'>
    alert('No fue posible completar la accion');
    location.assign('index.php');
    </script>";
  }

?>