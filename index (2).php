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

// Obtener el rol del usuario desde la sesión
$rolUsuario = $_SESSION['rol_ID'];

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
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
        .list-group-item {
            cursor: pointer;
        }
    </style>

    <script>
        // Función para confirmar el cierre de sesión
        function confirmarCerrarSesion() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Cerrar sesión',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, cerrar sesión'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'cerrar_sesion.php';
                }
            });
        }

    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Menú Principal</h2>
        <ul class="list-group">
            <?php
            if ($rolUsuario == 1) {
                // Administrador
                echo '<a href="crear_tarea.php" class="list-group-item list-group-item-action">Crear y Asignar Tarea</a>';
            }

            if (isset($_GET['error']) && $_GET['error'] === 'permisos_insuficientes') {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Permisos insuficientes!'
                        });
                    </script>";
            }
            ?>
            <a href="ver_tareas.php" class="list-group-item list-group-item-action">Ver Mis Tareas Asignadas</a>
            <li class="list-group-item list-group-item-action text-danger" onclick="confirmarCerrarSesion()">Cerrar sesión</li>
        </ul>
    </div>
</body>
</html>
