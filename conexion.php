<?php
/**
 * Conexión a la base de datos para Moto Rat
 * 
 * @version 1.1
 * @author TuNombre
 */

// Configuración de entorno (desarrollo/producción)
define('ENVIRONMENT', 'development'); // Cambiar a 'production' en servidor real

// Configuración de la base de datos
if (ENVIRONMENT === 'development') {
    // Configuración local (XAMPP)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'moto_rat_db');
    define('DB_PORT', '3306');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Configuración de producción
    define('DB_HOST', 'tu_servidor_produccion');
    define('DB_USER', 'usuario_seguro');
    define('DB_PASS', 'contraseña_compleja');
    define('DB_NAME', 'moto_rat_db_prod');
    define('DB_PORT', '3306');
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Manejo de errores personalizado
function handle_database_error($e) {
    error_log('[' . date('Y-m-d H:i:s') . '] Error DB: ' . $e->getMessage() . "\n", 3, __DIR__ . '/../logs/db_errors.log');
    
    if (ENVIRONMENT === 'development') {
        die('<div class="alert alert-danger">Error de base de datos: ' . htmlspecialchars($e->getMessage()) . '</div>');
    } else {
        die('<div class="alert alert-danger">Error en el sistema. Por favor intente más tarde.</div>');
    }
}

// Crear conexión
try {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Configurar charset
    if (!$conexion->set_charset("utf8mb4")) {
        throw new Exception("Error al establecer charset: " . $conexion->error);
    }
    
    // Configurar zona horaria si es necesario
    $conexion->query("SET time_zone = '-6:00'"); // Ajusta según tu zona horaria
    
} catch (Exception $e) {
    handle_database_error($e);
}

/**
 * Función para sanitizar datos de entrada
 * 
 * @param mixed $data Datos a sanitizar
 * @return mixed Datos sanitizados
 */
function limpiar_input($data) {
    global $conexion;
    
    if (is_array($data)) {
        return array_map('limpiar_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    return $conexion->real_escape_string($data);
}

/**
 * Función para ejecutar consultas preparadas de forma segura
 * 
 * @param string $sql Consulta SQL con placeholders
 * @param array $params Parámetros para bind
 * @return mysqli_result|bool Resultado de la consulta
 */
function ejecutar_consulta($sql, $params = []) {
    global $conexion;
    
    try {
        $stmt = $conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error al preparar consulta: " . $conexion->error);
        }
        
        if (!empty($params)) {
            $types = '';
            $values = [];
            
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            
            $stmt->bind_param($types, ...$values);
        }
        
        $stmt->execute();
        return $stmt;
        
    } catch (Exception $e) {
        handle_database_error($e);
        return false;
    }
}

// Cierre automático al finalizar el script
register_shutdown_function(function() {
    global $conexion;
    if (isset($conexion) && $conexion instanceof mysqli) {
        $conexion->close();
    }
});
?>
