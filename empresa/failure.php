<!DOCTYPE html>
<html>
<head>
    <title>Verificar Código Promocional</title>
</head>
<body>
    <h1>Verificar Código Promocional</h1>

    <?php
    // Verifica si se ha enviado el formulario
    if (isset($_POST['submit'])) {
        // Conexión a la base de datos (debes configurar esto)
        $conexion = mysqli_connect("nombre_del_servidor", "usuario", "contraseña", "nombre_de_la_base_de_datos");

        if (!$conexion) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        // Recupera el código promocional de la base de datos
        $query = "SELECT codigo_promocional FROM tabla_promociones WHERE id = 1"; // Cambia 'tabla_promociones' y 'id' según tu estructura de base de datos
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            $codigoPromocionalBD = $fila['codigo_promocional'];
            mysqli_free_result($resultado);

            // Recupera el código ingresado en el formulario
            $codigoIngresado = $_POST['codigo'];

            // Compara el código ingresado con el código de la base de datos
            if ($codigoIngresado === $codigoPromocionalBD) {
                echo "OK";
            } else {
                echo "Código promocional incorrecto";
            }
        } else {
            echo "Error al consultar la base de datos: " . mysqli_error($conexion);
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
    }
    ?>

    <form method="POST">
        <label for="codigo">Ingrese el código promocional:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" name="submit" value="Verificar">
    </form>
</body>
</html>