# Moto Rat - Sistema de Contacto y Créditos

## Estructura de Base de Datos

### Tabla `contactos`
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- nombre (VARCHAR 100, NOT NULL)
- email (VARCHAR 100, NOT NULL)
- asunto (VARCHAR 200)
- mensaje (TEXT, NOT NULL)
- fecha_envio (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- ip_cliente (VARCHAR 45)
- user_agent (VARCHAR 255)

### Tabla `solicitudes_credito`
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- nombre_completo (VARCHAR 150, NOT NULL)
- email (VARCHAR 100, NOT NULL)
- telefono (VARCHAR 20, NOT NULL)
- monto_solicitado (DECIMAL 10,2, NOT NULL)
- producto_interes (ENUM: 'Moto deportiva', 'Accesorios', 'Refacciones', 'Equipo de protección', NOT NULL)
- fecha_solicitud (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- ip_cliente (VARCHAR 45)
- user_agent (VARCHAR 255)
- estado (ENUM: 'pendiente', 'revisado', 'aprobado', 'rechazado', DEFAULT 'pendiente')

## Instalación
1. Importar `moto_rat_db.sql` en phpMyAdmin
2. Configurar credenciales en `includes/conexion.php`
3. Cambiar `contact.html` a `contact.php`
