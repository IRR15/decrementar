<?php
include "conexion.php";
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restar'])) {
        $identificador = $_POST["restar"];
        // Decrementar el inventario en la base de datos
        $sql = "UPDATE persona SET inventario = inventario - 1 WHERE id = $identificador";
        mysqli_query($conexion, $sql);
        // Si el inventario llega a 0, eliminar la imagen
        $sql_check_inventory = "SELECT inventario FROM persona WHERE id = $identificador";
        $result_check_inventory = mysqli_query($conexion, $sql_check_inventory);
        $row = mysqli_fetch_assoc($result_check_inventory);
        if ($row['inventario'] <= 0) {
            // Eliminar la imagen
            $sql_delete_image = "UPDATE persona SET imagen = NULL WHERE id = $identificador";
            mysqli_query($conexion, $sql_delete_image);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Guardados</title>
    <script>
        function decrementar(id) {
            document.getElementById("restar_" + id).submit();
        }
    </script>
</head>
<body>
    <center>
        <h1>Datos Guardados</h1>
        <table>
            <tr>
                <th>ID </th>
                <th>Imagen </th>
                <th>Descripcion </th>
                <th>Inventario </th>
            </tr>
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM persona");
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){

                ?>
                <tr>
                    <td><?php echo $data['id'] ?></td>
                    <td><img height = "50px" src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>"></td>
                    <td><?php echo $data['descripcion'] ?></td>
                    <td><?php echo $data['inventario'] ?></td>
                </tr>

                <?php
                }
            }
            ?>
        </table>
        <?php
        mysqli_data_seek($query, 0); // Reiniciar el puntero del resultado
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <!-- Formulario para enviar la solicitud POST -->
            <form id="restar_<?php echo $data['id'] ?>" action="" method="post" style="display: inline;">
                <input type="hidden" name="restar" value="<?php echo $data['id'] ?>">
                <button type="button" onclick="decrementar(<?php echo $data['id'] ?>)">Decrementar</button>
            </form>
        <?php
        }
        ?>
        
        <button><a href="index.php">Regresar</a></button>
    </center>
</body>
</html>