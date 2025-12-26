# 📧 Sistema de Notificación con ActiveCampaign API

## Descripción

Sistema completo de gestión de usuarios integrado con **ActiveCampaign** que:
1. **Sincroniza contactos** automáticamente usando ActiveCampaign API
2. **Envía correos transaccionales** directamente desde ActiveCampaign (sin SMTP)
3. **Notifica** al usuario creado y al administrador

## 🔧 Configuración

### ActiveCampaign API

**Paquete instalado:**
```bash
composer require activecampaign/api-php
```

**Credenciales en `.env`:**
```env
ACTIVECAMPAIGN_URL=https://humanandjob.api-us1.com
ACTIVECAMPAIGN_API_KEY=3c0e8ad1be14d8bdfb66d6b3c83bfc5f4bcedbdbb3437f12c5f67c51dfbff97df6c6d191

MAIL_FROM_ADDRESS="fbotasso@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
ADMIN_EMAIL="fbotasso@gmail.com"
```

**Acceso a ActiveCampaign:**
- URL: https://humanandjob.activehosted.com
- Usuario: admin
- Contraseña: D186LNA2TP#L

### ✅ Sin necesidad de SMTP

El sistema usa la **API de ActiveCampaign** para enviar correos, por lo que NO necesitas configurar SMTP.

## 📬 Tipos de Correos

### 1. Correo al Usuario Creado
**Archivo:** `app/Mail/UserCreatedNotification.php`  
**Vista:** `resources/views/emails/user-created.blade.php`

**Contenido:**
- Saludo personalizado con el nombre completo
- Credenciales de acceso (email y contraseña temporal)
- Rol asignado
- Botón para iniciar sesión
- Recomendación de cambiar contraseña

### 2. Correo al Administrador
**Archivo:** `app/Mail/AdminUserCreatedNotification.php`  
**Vista:** `resources/views/emails/admin-user-created.blade.php`

**Contenido:**
- Notificación de nuevo registro
- Información completa del usuario:
  - Nombre completo (separado en campos)
  - Correo electrónico
  - Rol asignado (con badge de color)
  - Fecha y hora de registro
  - ID de usuario
- Confirmación de que el usuario fue notificado

## 🔄 Flujo Completo al Crear un Usuario

### Proceso automatizado:

1. **Creación en Base de Datos Local** ✅
2. **Sincronización con ActiveCampaign API** ✅
   - Crear/actualizar contacto
   - Agregar campos personalizados (rol, teléfono, etc.)
3. **Envío de Correo al Usuario** ✅
   - Usando API de ActiveCampaign (no SMTP)
   - Con credenciales de acceso
4. **Envío de Correo al Administrador** ✅
   - Notificación del nuevo registro
   - Información completa del usuario

### Implementación en Código:

**`app/Actions/Fortify/CreateNewUser.php`** - Registro público
**`app/Http/Controllers/UserController.php`** - Registro desde dashboard

Ambos siguen el mismo flujo:
```php
// 1. Crear usuario
$user = User::create([...]);

// 2. Sincronizar con ActiveCampaign
$activeCampaign->createOrUpdateContact([...]);

// 3. Enviar correos via API
$activeCampaign->sendTransactionalEmail([
    'to' => $user->email,
    'subject' => 'Bienvenido...',
    'html' => view('emails.user-created')->render()
]);
```

## 🔗 Integración con ActiveCampaign

### Servicio de ActiveCampaign
**Archivo:** `app/Services/ActiveCampaignService.php`

Este servicio proporciona métodos para:
- ✅ Crear o actualizar contactos
- ✅ Buscar contactos por email
- ✅ **Enviar correos transaccionales** (NEW!)
- ✅ Disparar automatizaciones
- ✅ Agregar tags a contactos
- ✅ Suscribir contactos a listas
- ✅ Probar la conexión con la API

### Métodos principales:

```php
// Crear/actualizar contacto
$service->createOrUpdateContact([
    'email' => 'usuario@example.com',
    'first_name' => 'Juan',
    'last_name' => 'Pérez',
    'phone' => '+56912345678',
    'custom_fields' => [
        ['field' => '1', 'value' => 'profesional']
    ]
]);

// Enviar correo transaccional
$service->sendTransactionalEmail([
    'to' => 'usuario@example.com',
    'subject' => 'Bienvenido',
    'html' => $htmlContent
]);

// Disparar automatización
$service->triggerAutomation('usuario@example.com', $automationId);

// Buscar contacto
$contact = $service->getContactByEmail('usuario@example.com');
```

## ⚡ Sistema de Colas

Los correos pueden enviarse de forma **síncrona** (inmediata) o **asíncrona** (en cola).

**Configuración actual:** Síncrona (sin colas)
- Los correos se envían inmediatamente
- Recomendado para desarrollo y pruebas

**Para habilitar colas (producción):**
1. Agregar `implements ShouldQueue` en las clases Mailable
2. Configurar `QUEUE_CONNECTION=database` en `.env`
3. Ejecutar worker: `php artisan queue:work`

## 🎨 Diseño de Correos

Los correos tienen un diseño profesional y responsivo:

### Características:
- ✅ HTML responsivo
- ✅ Colores corporativos con gradientes
- ✅ Estructura clara y organizada
- ✅ Botones de acción destacados
- ✅ Información formateada en tablas
- ✅ Badges de colores para roles
- ✅ Footer con información legal

### Roles y Colores:
- **Admin:** Rojo (#dc3545)
- **Profesional:** Azul (#007bff)
- **Empresa:** Verde (#28a745)

## 🔐 Seguridad

### Contraseñas
- Las contraseñas se guardan **hasheadas** en la base de datos
- Se envía la contraseña en **texto plano** solo en el correo inicial
- La contraseña temporal no se almacena en ningún lugar después del envío
- Se recomienda al usuario cambiar su contraseña tras el primer inicio de sesión

### Validaciones
- Email único en la base de datos
- Contraseña mínima de 8 caracteres
- Validación de roles permitidos: admin, profesional, empresa
- Validación de formato de email

## 📝 Logs y Depuración

### Ver correos en desarrollo (sin enviar)
Cambiar en `.env`:
```env
MAIL_MAILER=log
```
Los correos se guardarán en `storage/logs/laravel.log`

### Ver estado de la cola
```bash
php artisan queue:monitor
```

### Reintentar trabajos fallidos
```bash
php artisan queue:retry all
```

## 🚀 Despliegue en Producción

### Checklist:
1. ✅ Verificar credenciales de ActiveCampaign en `.env`
2. ✅ Configurar `APP_ENV=production`
3. ✅ Configurar supervisor para `queue:work`
4. ✅ Verificar que el puerto 587 esté abierto en el firewall
5. ✅ Probar envío de correo de prueba
6. ✅ Monitorear logs de errores

### Comando de supervisor (ejemplo):
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /ruta/a/tu/proyecto/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/ruta/a/tu/proyecto/storage/logs/worker.log
```

## 🧪 Pruebas

### Comando de Prueba Rápido

El sistema incluye un comando artisan para probar el envío de correos fácilmente:

```bash
# Enviar correos de prueba usando el primer usuario
php artisan email:test

# Enviar correos usando un usuario específico
php artisan email:test --user-id=2

# Enviar correos a un email diferente
php artisan email:test --to=test@example.com

# Combinado
php artisan email:test --user-id=2 --to=test@example.com
```

### Probar ActiveCampaign

```bash
# Probar conexión con ActiveCampaign API
php artisan activecampaign:test

# Esto te permitirá:
# - Verificar credenciales
# - Ver el estado de la conexión
# - Crear un contacto de prueba
```

### Probar envío manual con Tinker:
```bash
php artisan tinker
```

```php
$user = \App\Models\User::first();
\Illuminate\Support\Facades\Mail::to('test@example.com')
    ->send(new \App\Mail\UserCreatedNotification($user, 'password123'));

// Probar ActiveCampaign
$service = new \App\Services\ActiveCampaignService();
$service->testConnection();
```

## 📞 Soporte

Para problemas con el envío de correos:
1. Verificar logs en `storage/logs/laravel.log`
2. Verificar configuración SMTP en `.env`
3. Verificar estado de ActiveCampaign
4. Contactar a soporte de ActiveCampaign si es necesario

## 📊 Estadísticas

Los correos enviados a través de ActiveCampaign se pueden monitorear desde el panel de administración:
- URL: https://humanandjob.activehosted.com
- Sección: Reporting > Email Reports

---

**Última actualización:** 6 de noviembre de 2025  
**Versión:** 1.0  
**Desarrollado por:** Sistema Admin Laravel
