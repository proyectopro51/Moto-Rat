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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Moto Rat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- Tu encabezado aquí -->
    </header>

    <main>
        <section class="contact-form">
            <h1>Contacto</h1>
            
            <?php if (!empty($errores)): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (isset($mensaje_exito)): ?>
                <div class="alert success">
                    <?= $mensaje_exito ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="contactos.php">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>
                </div>
                
                <button type="submit">Enviar Mensaje</button>
            </form>
        </section>
    </main>

    <footer>
        <!-- Tu pie de página aquí -->
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>

