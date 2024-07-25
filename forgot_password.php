<?php
include 'db.php';
include 'functions.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = generateResetToken();

    $sql = "UPDATE users SET reset_token = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $resetLink = "http://example.com/reset_password.php?token=$token";
    $subject = "Restablecimiento de Contraseña";
    $message = "Haga clic en el siguiente enlace para restablecer su contraseña: $resetLink";
    sendConfirmationEmail($email, $subject, $message);

    echo "Se ha enviado un enlace para restablecer la contraseña a su correo.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidó su Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('5096160.jpg'); /* Imagen de fondo */
            background-size: cover; /* Ajusta la imagen de fondo */
            background-position: center;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: bold;
            text-align: left;
        }
        input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .icon {
            margin-right: 8px;
        }
        .error {
            color: #e74c3c;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-envelope icon"></i> Olvidó su Contraseña</h2>
        <form method="post">
            <label for="email"><i class="fas fa-envelope icon"></i> Correo:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" name="submit"><i class="fas fa-paper-plane icon"></i> Enviar enlace</button>
        </form>
    </div>
</body>
</html>

