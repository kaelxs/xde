<?php
include 'db.php';
include 'functions.php';

if (isset($_POST['reset'])) {
    $token = $_GET['token'];
    $newPassword = $_POST['password'];

    $hashedPassword = hashPassword($newPassword);

    $sql = "UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $token);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <form method="post">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="reset">Restablecer Contraseña</button>
    </form>
</body>
</html>
