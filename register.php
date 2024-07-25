<?php
include 'db.php';
include 'functions.php';

if (isset($_POST['register'])) {
    $docType = $_POST['docType'];
    $docNumber = $_POST['docNumber'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hashedPassword = hashPassword($password);

        $sql = "INSERT INTO users (doc_type, doc_number, name, address, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $docType, $docNumber, $name, $address, $email, $phone, $hashedPassword);
        $stmt->execute();

        $subject = "Confirmación de registro";
        $message = "Gracias por registrarte. Tu cuenta ha sido creada.";
        sendConfirmationEmail($email, $subject, $message);

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+CU:wght@100..400&family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
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
            background-size: cover;
            background-position: center;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #555;
            gap: 10px;
            text-align: left;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .icon {
            color: #007bff;
        }
        .password-validation {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .validation-icon {
            color: red; /* Por defecto, color de la X */
            font-size: 18px;
        }
        .validation-icon.valid {
            color: green; /* Color del check cuando es válido */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-plus icon"></i> Registro de Usuario</h1>
        <form method="post">
            <label for="docNumber"><i class="fas fa-id-card icon"></i> Número de Documento:</label>
            <input type="text" id="docNumber" name="docNumber" required>
            
            <label for="name"><i class="fas fa-user icon"></i> Nombre:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="address"><i class="fas fa-map-marker-alt icon"></i> Dirección:</label>
            <input type="text" id="address" name="address" required>
            
            <label for="email"><i class="fas fa-envelope icon"></i> Correo:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone"><i class="fas fa-phone icon"></i> Celular:</label>
            <input type="text" id="phone" name="phone" required>
            
            <label for="password"><i class="fas fa-lock icon"></i> Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirmPassword"><i class="fas fa-lock icon"></i> Confirmar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            
            <div class="password-validation">
                <span id="passwordMatch" class="validation-icon"></span>
                <span id="passwordMatchText">Las contraseñas coinciden</span>
            </div>
            
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            
            <button type="submit" name="register"><i class="fas fa-user-plus icon"></i> Registrarse</button>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordMatchIcon = document.getElementById('passwordMatch');
        const passwordMatchText = document.getElementById('passwordMatchText');

        function validatePassword() {
            if (passwordInput.value === confirmPasswordInput.value) {
                passwordMatchIcon.classList.add('valid');
                passwordMatchIcon.classList.remove('invalid');
                passwordMatchIcon.innerHTML = '<i class="fas fa-check"></i>';
                passwordMatchText.style.color = 'green';
            } else {
                passwordMatchIcon.classList.add('invalid');
                passwordMatchIcon.classList.remove('valid');
                passwordMatchIcon.innerHTML = '<i class="fas fa-times"></i>';
                passwordMatchText.style.color = 'red';
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);
    </script>
</body>
</html>
