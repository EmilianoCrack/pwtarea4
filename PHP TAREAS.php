<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'];
    $id_usuario = $_SESSION['user_id']; // Asegúrate de tener el ID del usuario

    $sql = "INSERT INTO tareas (descripcion, id_usuario) VALUES ('$descripcion', '$id_usuario')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nueva tarea creada exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>