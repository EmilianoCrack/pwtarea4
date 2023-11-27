<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, id_rol FROM usuarios WHERE nombre = '$username' AND contraseña = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['login_user'] = $username;
        $_SESSION['role'] = $row['id_rol'];
        header("location: welcome.php");
    } else {
        $error = "Tu nombre de usuario o contraseña es inválido";
    }
}
?><?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, id_rol FROM usuarios WHERE nombre = '$username' AND contraseña = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['login_user'] = $username;
        $_SESSION['role'] = $row['id_rol'];
        header("location: welcome.php");
    } else {
        $error = "Tu nombre de usuario o contraseña es inválido";
    }
}
?><?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, id_rol FROM usuarios WHERE nombre = '$username' AND contraseña = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['login_user'] = $username;
        $_SESSION['role'] = $row['id_rol'];
        header("location: welcome.php");
    } else {
        $error = "Tu nombre de usuario o contraseña es inválido";
    }
}
?>