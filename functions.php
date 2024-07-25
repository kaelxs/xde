<?php
// Función para cifrar contraseñas
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Función para verificar contraseñas
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Función para enviar correo de confirmación
function sendConfirmationEmail($to, $subject, $message) {
    $headers = "From: no-reply@example.com\r\n";
    return mail($to, $subject, $message, $headers);
}

// Función para generar token de recuperación de contraseña
function generateResetToken($length = 32) {
    return bin2hex(random_bytes($length));
}
?>
