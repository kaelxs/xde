<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+CU:wght@100..400&family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
            background-image: url('5096160.jpg'); /* Agrega la imagen de fondo */
            background-size: cover; /* Ajusta la imagen para cubrir todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #007bff;
            display: inline-block;
        }
        a:hover {
            background-color: #007bff;
            color: #fff;
        }
        .logout-button {
            background-color: #dc3545;
            border: 1px solid #dc3545;
            color: #fff;
        }
        .logout-button:hover {
            background-color: #c82333;
            border: 1px solid #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a nuestro sistema de autenticación, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p>Estamos encantados de tenerte con nosotros. ¿Qué te gustaría hacer hoy?</p>
        <a href="update.php">Actualizar Datos</a>
        <a href="index.php" class="logout-button">Cerrar sesión</a>
    </div>
</body>
</html>


