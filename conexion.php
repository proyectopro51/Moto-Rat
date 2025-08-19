<?php
// Iniciar sesión para almacenar mensajes entre redirecciones
session_start();

// Encabezado obligatorio para evitar descarga
header('Content-Type: text/html; charset=utf-8');

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
            // En un caso real, aquí se insertaría en la base de datos
            // Por ahora simulamos el guardado exitoso
            $id_simulado = rand(1000, 9999);
            $_SESSION['mensaje_exito'] = "Mensaje enviado correctamente. ID: " . $id_simulado;
            
            // Redirigir para evitar reenvío del formulario
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (Exception $e) {
            $errores[] = "Error al guardar: " . $e->getMessage();
            $_SESSION['errores'] = $errores;
        }
    } else {
        $_SESSION['errores'] = $errores;
    }
}

// Recuperar mensajes de sesión
$errores = $_SESSION['errores'] ?? [];
$mensaje_exito = $_SESSION['mensaje_exito'] ?? '';

// Limpiar mensajes de sesión después de mostrarlos
unset($_SESSION['errores']);
unset($_SESSION['mensaje_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Contacto - Moto Rat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Mismo CSS que en contacto.html */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 2.2rem;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 25px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Main Content */
        main {
            flex: 1;
            padding: 2rem 0;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }
        
        .page-title h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: #d32f2f;
        }
        
        .page-title p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Contact Form */
        .contact-form {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 600;
            color: #444;
            font-size: 1.1rem;
        }
        
        input, textarea {
            width: 100%;
            padding: 14px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
        }
        
        textarea {
            min-height: 180px;
            resize: vertical;
        }
        
        button {
            background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Alerts */
        .alert {
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        
        .alert.error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        
        .alert.success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        
        .alert ul {
            margin-left: 25px;
        }
        
        /* Contact Info */
        .contact-info {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 3rem;
            gap: 20px;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            min-width: 250px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-card i {
            font-size: 2.5rem;
            color: #d32f2f;
            margin-bottom: 15px;
        }
        
        .info-card h3 {
            margin-bottom: 10px;
            color: #333;
        }
        
        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2.5rem 0;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .social-icons {
            margin: 20px 0;
        }
        
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin: 0 15px;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: #d32f2f;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 1.5rem;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            nav ul li {
                margin: 0 10px 10px;
            }
            
            .contact-form {
                padding: 1.8rem;
            }
            
            .page-title h1 {
                font-size: 2rem;
            }
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #d32f2f;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border: 2px solid #d32f2f;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .back-link a:hover {
            background-color: #d32f2f;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-motorcycle"></i>
                <span>Moto Rat</span>
            </div>
            <nav>
                <ul>
                    <li><a href="contacto.html"><i class="fas fa-home"></i> Inicio</a></li>
                    <li><a href="#"><i class="fas fa-warehouse"></i> Productos</a></li>
                    <li><a href="#"><i class="fas fa-tools"></i> Servicios</a></li>
                    <li><a href="contacto.html"><i class="fas fa-phone"></i> Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="page-title">
            <h1>Resultado del contacto</h1>
            <p>Procesamiento de tu mensaje de contacto</p>
        </div>
        
        <section class="contact-form">
            <?php if (!empty($errores)): ?>
                <div class="alert error">
                    <h3>Error en el formulario:</h3>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="back-link">
                    <a href="contacto.html">← Volver al formulario de contacto</a>
                </div>
            <?php elseif (isset($mensaje_exito)): ?>
                <div class="alert success">
                    <h3>¡Éxito!</h3>
                    <p><?= $mensaje_exito ?></p>
                </div>
                
                <div class="back-link">
                    <a href="contacto.html">← Volver al formulario de contacto</a>
                </div>
            <?php else: ?>
                <div class="alert error">
                    <h3>Error</h3>
                    <p>No se recibieron datos del formulario.</p>
                </div>
                
                <div class="back-link">
                    <a href="contacto.html">← Volver al formulario de contacto</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container footer-content">
            <p>© 2023 Moto Rat - Todos los derechos reservados</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p>Desarrollado con <i class="fas fa-heart" style="color: #d32f2f;"></i> para los amantes de las motos</p>
        </div>
    </footer>
</body>
</html>
