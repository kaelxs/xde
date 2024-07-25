<?php
session_start();
include 'db.php';
include 'functions.php'; // Asegúrate de incluir funciones como hashPassword() y verifyPassword()

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Verifica la contraseña actual y actualiza los datos
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && verifyPassword($currentPassword, $user['password'])) {
        if ($newPassword === $confirmNewPassword) {
            $hashedPassword = hashPassword($newPassword);
            $sql = "UPDATE users SET name = ?, address = ?, phone = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $address, $phone, $email, $hashedPassword, $_SESSION['user_id']);
            $stmt->execute();
            echo "<p class='success'>Datos actualizados.</p>";
        } else {
            echo "<p class='error'>La nueva contraseña y la confirmación no coinciden.</p>";
        }
    } else {
        echo "<p class='error'>La contraseña actual es incorrecta.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            color: #495057;
            margin: 0;
            padding: 0;
            text-align: center;
             background-image: url('5096160.jpg'); /* Imagen de fondo */
            background-size: cover;
            background-position: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: #343a40;
            text-align: left;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            border: none;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error, .success {
            margin: 10px 0;
            font-size: 16px;
        }
        .error {
            color: #dc3545;
        }
        .success {
            color: #28a745;
        }
        .password-validation {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .validation-icon {
            font-size: 20px;
            color: red; /* Por defecto, color de la X */
        }
        .validation-icon.valid {
            color: green; /* Color del check cuando es válido */
        }
        .validation-text {
            font-size: 14px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-edit"></i> Actualizar Datos</h1>
        <form method="post">
            <label for="name"><i class="fas fa-user"></i> Nombre:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="address"><i class="fas fa-map-marker-alt"></i> Dirección:</label>
            <input type="text" id="address" name="address" required>
            
            <label for="phone"><i class="fas fa-phone"></i> Teléfono:</label>
            <input type="text" id="phone" name="phone" required>
            
            <label for="email"><i class="fas fa-envelope"></i> Correo:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="currentPassword"><i class="fas fa-lock"></i> Contraseña Actual:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>
            
            <label for="newPassword"><i class="fas fa-lock"></i> Nueva Contraseña:</label>
            <input type="password" id="newPassword" name="newPassword">
            
            <label for="confirmNewPassword"><i class="fas fa-lock"></i> Repita Nueva Contraseña:</label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword">
            
            <div class="password-validation">
                <span id="passwordMatchIcon" class="validation-icon"></span>
                <span id="passwordMatchText" class="validation-text">Las contraseñas coinciden</span>
            </div>
            
            <button type="submit" name="update"><i class="fas fa-save"></i> Actualizar Datos</button>
        </form>
    </div>

    <script>
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmNewPassword');
        const passwordMatchIcon = document.getElementById('passwordMatchIcon');
        const passwordMatchText = document.getElementById('passwordMatchText');

        function validatePasswords() {
            if (newPasswordInput.value === confirmPasswordInput.value) {
                passwordMatchIcon.classList.add('valid');
                passwordMatchIcon.classList.remove('invalid');
                passwordMatchIcon.innerHTML = '<i class="fas fa-check"></i>';
                passwordMatchText.textContent = 'Las contraseñas coinciden';
                passwordMatchText.style.color = 'green';
            } else {
                passwordMatchIcon.classList.add('invalid');
                passwordMatchIcon.classList.remove('valid');
                passwordMatchIcon.innerHTML = '<i class="fas fa-times"></i>';
                passwordMatchText.textContent = 'Las contraseñas no coinciden';
                passwordMatchText.style.color = 'red';
            }
        }

        newPasswordInput.addEventListener('input', validatePasswords);
        confirmPasswordInput.addEventListener('input', validatePasswords);
    </script>
</body>
</html>
