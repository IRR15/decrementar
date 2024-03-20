<?php
require_once('conexion.php');
if(empty($_POST['descripcion']) || empty($_POST['inventario'])){

    echo "POR FAVOR LLENE LOS DATOS LA IMAGENES TIENEN QUE SER JPG";

}else{
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $descripcion = $_POST['descripcion'];
    $inventario = $_POST['inventario'];
    $query = "INSERT INTO persona (imagen, descripcion, inventario) VALUES ('$imagen', '$descripcion', '$inventario')";
    $resultado = $conexion->query($query);

    if($resultado){
        echo "Se ingresaron los datos";
    }else{
        echo "No se guardaron los datos";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de datos</title>
    <link rel="stylesheet" type = "text/css" href="style/style.css">
</head>
<body>
    <center>
        <h1>Datos</h1>
        <form method = "POST" enctype = "multipart/form-data">
            <h1>Ingresa los datos</h1>
            <label>Foto: </label>
            <input type="file" name = "imagen" require = ""><br><br>
            <label>Descripcion: </label>
            <input type="text" name="descripcion"><br><br>
            <label >Inventario: </label>
            <input type="number" name = "inventario"><br><br>
            <center>
                <input type="submit" name = "Guardar" value = "Guardar">
                <button><a href="consulta.php">Consultar</a></button>
            </center>
        </form>
    </center>
</body>
</html>