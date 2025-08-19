<?php
// Encabezado obligatorio para evitar descarga
header('Content-Type: text/html; charset=utf-8');

// Incluir conexión a la base de datos
require_once 'conexion.php';

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar y validar datos
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje'] ?? '');
    
    // Validaciones básicas
    $errores = [];
    if (empty($nombre)) $errores[] = "El nombre es requerido";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido";
    if (empty($mensaje)) $errores[] = "El mensaje es requerido";
    
    if (empty($errores)) {
        try {
            // Insertar en base de datos (ejemplo)
            $stmt = $conexion->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $mensaje);
            $stmt->execute();
            
            $mensaje_exito = "Mensaje enviado correctamente. ID: " . $stmt->insert_id;
            $stmt->close();
        } catch (Exception $e) {
            $errores[] = "Error al guardar: " . $e->getMessage();
        }
    }
}
?>
