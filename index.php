<?php
session_start();
include 'db.php';
include 'functions.php'; // Asegúrate de incluir este archivo

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && verifyPassword($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Correo electrónico o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+CU:wght@100..400&family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center; /* Centra el contenedor horizontalmente */
            align-items: center; /* Centra el contenedor verticalmente */
            height: 100vh;
            margin: 0;
            padding-right: 20px; /* Añade espacio al borde derecho */
            background-image: url('5096160.jpg'); /* Agrega la imagen de fondo */
            background-size: cover; /* Ajusta la imagen para cubrir todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
            .zilla-slab-light {
  font-family: "Zilla Slab", serif;
  font-weight: 300;
  font-style: normal;
}

.zilla-slab-regular {
  font-family: "Zilla Slab", serif;
  font-weight: 400;
  font-style: normal;
}

.zilla-slab-medium {
  font-family: "Zilla Slab", serif;
  font-weight: 500;
  font-style: normal;
}

.zilla-slab-semibold {
  font-family: "Zilla Slab", serif;
  font-weight: 600;
  font-style: normal;
}

.zilla-slab-bold {
  font-family: "Zilla Slab", serif;
  font-weight: 700;
  font-style: normal;
}

.zilla-slab-light-italic {
  font-family: "Zilla Slab", serif;
  font-weight: 300;
  font-style: italic;
}

.zilla-slab-regular-italic {
  font-family: "Zilla Slab", serif;
  font-weight: 400;
  font-style: italic;
}

.zilla-slab-medium-italic {
  font-family: "Zilla Slab", serif;
  font-weight: 500;
  font-style: italic;
}

.zilla-slab-semibold-italic {
  font-family: "Zilla Slab", serif;
  font-weight: 600;
  font-style: italic;
}

.zilla-slab-bold-italic {
  font-family: "Zilla Slab", serif;
  font-weight: 700;
  font-style: italic;
}

        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50vw; /* Ocupa la mitad del ancho de la ventana */
            max-width: 600px; /* Máximo ancho del contenedor */
            min-width: 300px; /* Mínimo ancho del contenedor */
            min-height: 500px; /* Altura mínima para el contenedor */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centra verticalmente el contenido del contenedor */
            align-items: center; /* Centra horizontalmente el contenido del contenedor */
            margin-right: 20px; /* Añade margen a la derecha del contenedor */
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px; /* Aumenta el tamaño del texto */
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="email"], input[type="password"] {
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
        .links {
            margin-top: 10px;
        }
        .links a {
            color: #000; /* Color negro para los enlaces */
            text-decoration: none;
            font-size: 14px;
            margin: 0 5px;
            display: inline-flex;
            align-items: center;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .icon {
            margin-right: 8px;
            color: #000; /* Iconos en color negro */
        }
        .error {
            color: #e74c3c;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-sign-in-alt icon"></i> Iniciar sesión</h2>
        <form method="post">
            <label for="email"><i class="fas fa-envelope icon"></i> Correo:</label>
            <input type="email" id="email" name="email" required>
            <label for="password"><i class="fas fa-lock icon"></i> Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Iniciar sesión</button>
        </form>
        <div class="links">
            <a href="forgot_password.php"><i class="fas fa-question-circle icon"></i> Olvidó su contraseña?</a>
            <a href="register.php"><i class="fas fa-user-plus icon"></i> Registrarse</a>
        </div>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
