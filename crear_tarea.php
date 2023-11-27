<?php
// Verificar si el usuario está autenticado y es administrador
session_start();
if (!isset($_SESSION['usuario_ID'])) {
    header("Location: login.php?error=no_sesion_iniciada");
    exit();
}

if ($_SESSION['rol_ID'] != 1) {
    header("Location: index.php?error=permisos_insuficientes");
    exit();
}


$servername = "sql213.infinityfree.com";
$username = "if0_35505833";
$password = "moyLxvvte8bR8AW";
$dbname = "if0_35505833_tareapractica4";


// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'];
    $usuarioID = $_POST['usuario'];

    // Insertar la nueva tarea en la base de datos
    $sql = "INSERT INTO Tareas (Descripcion, Estado, Usuario_ID) VALUES ('$descripcion', 'Pendiente', $usuarioID)";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Tarea creada y asignada con éxito.";
    } else {
        $error = "Error al crear la tarea: " . $conn->error;
    }
}

// Obtener la lista de usuarios para asignar tareas
$sqlUsuarios = "SELECT ID, Usuario FROM Usuarios";
$resultUsuarios = $conn->query($sqlUsuarios);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear y Asignar Tarea</title>
    <!-- Agrega enlaces a Bootstrap y tus estilos de CSS aquí -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Crear y Asignar Tarea</h2>
        <?php
        if (isset($mensaje)) {
            echo "<div class='alert alert-success'>$mensaje</div>";
        }
        if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="descripcion">Descripción de la Tarea:</label>
                <input type="text" class="form-control" name="descripcion" required>
            </div>
            <div class="form-group">
                <label for="usuario">Asignar a Usuario:</label>
                <select class="form-control" name="usuario" required>
                    <?php
                    while ($rowUsuario = $resultUsuarios->fetch_assoc()) {
                        echo "<option value='{$rowUsuario["ID"]}'>{$rowUsuario["Usuario"]}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear y Asignar Tarea</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Volver al Listado de Tareas</a>
    </div>
</body>
</html>
