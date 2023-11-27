<?php
// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['usuario_ID'])) {
    header("Location: login.php?error=no_sesion_iniciada");
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

// Obtener el ID del usuario desde la sesión
$usuarioID = $_SESSION['usuario_ID'];
$TareaCompletada = false;
// Procesar la acción de marcar como completada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tarea_completada'])) {
        $tareaID = $_POST['tarea_completada'];

        // Actualizar el estado de la tarea a 'Completada'
        $sqlActualizar = "UPDATE Tareas SET Estado = 'Completada' WHERE ID = $tareaID AND Usuario_ID = $usuarioID";
        $conn->query($sqlActualizar);
        $TareaCompletada = true;
    }
}

// Consulta para obtener las tareas pendientes del usuario
$sqlTareas = "SELECT ID, Descripcion, Estado FROM Tareas WHERE Usuario_ID = $usuarioID AND Estado = 'Pendiente'";
$resultTareas = $conn->query($sqlTareas);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mis Tareas</title>
    <!-- Agrega enlaces a Bootstrap y tus estilos de CSS aquí -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Mis Tareas Pendientes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($TareaCompletada) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Informacion',
                            text: 'La tarea fue marcada como completada!'
                        });
                    </script>";
                }
                if ($resultTareas->num_rows > 0) {
                    while ($rowTarea = $resultTareas->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rowTarea["ID"] . "</td>";
                        echo "<td>" . $rowTarea["Descripcion"] . "</td>";
                        echo "<td>" . $rowTarea["Estado"] . "</td>";
                        echo "<td>
                                <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                    <input type='hidden' name='tarea_completada' value='{$rowTarea["ID"]}'>
                                    <button type='submit' class='btn btn-success btn-sm'>Marcar como Completada</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay tareas pendientes.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary mt-3">Volver al Menú Principal</a>
    </div>
</body>
</html>
