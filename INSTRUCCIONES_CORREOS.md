# 📧 Sistema de Envío de Correos - Instrucciones

## ⚠️ PROBLEMA ENCONTRADO

**ActiveCampaign API v3 NO envía correos transaccionales directamente.**

El endpoint `/api/3/messages` solo **REGISTRA** mensajes en el sistema, NO los envía a las bandejas de entrada.

---

## ✅ SOLUCIONES DISPONIBLES

### **Opción 1: Usar Postmark (RECOMENDADO)**

Postmark es el mejor servicio para correos transaccionales. Tiene:
- ✅ Entrega garantizada
- ✅ 100 correos gratis al mes
- ✅ Fácil configuración
- ✅ Excelente reputación de entrega

#### Pasos para configurar Postmark:

1. **Crear cuenta en Postmark**
   - Ir a: https://postmarkapp.com/
   - Registrarse (gratis)
   - Crear un "Server" (servidor)
   - Obtener el **Server API Token**

2. **Configurar en Laravel**
   - Agregar en `.env`:
   ```
   POSTMARK_TOKEN=tu-token-de-postmark
   ```

3. **Verificar tu dominio**
   - En Postmark > Sender Signatures
   - Agregar tu dominio de correo
   - Configurar registros DNS (SPF, DKIM)

4. **Usar en el código**
   ```php
   use App\Services\PostmarkService;
   
   $postmark = new PostmarkService();
   $postmark->sendEmail([
       'to' => 'usuario@example.com',
       'subject' => 'Bienvenido',
       'html' => view('emails.user-created', $data)->render()
   ]);
   ```

---

### **Opción 2: Usar Automatizaciones de ActiveCampaign**

Si quieres seguir usando ActiveCampaign, debes usar sus automatizaciones:

#### Pasos:

1. **Crear automatización en ActiveCampaign**
   - Ir al panel de ActiveCampaign
   - Automations > Create an automation
   - Trigger: "Contact is added to automation"
   - Action: "Send an email"
   - Diseñar el correo en ActiveCampaign
   - Anotar el ID de la automatización

2. **Disparar desde Laravel**
   ```php
   use App\Services\ActiveCampaignService;
   
   $ac = new ActiveCampaignService();
   $ac->sendEmailViaAutomation(
       email: 'usuario@example.com',
       automationId: 123, // ID de tu automatización
       data: [
           'first_name' => 'Juan',
           'last_name' => 'Pérez'
       ]
   );
   ```

---

### **Opción 3: Usar otros servicios**

Alternativas a Postmark:

- **SendGrid**: https://sendgrid.com/ (100 correos/día gratis)
- **Mailgun**: https://www.mailgun.com/ (5,000 correos/mes gratis)
- **Amazon SES**: https://aws.amazon.com/ses/ (62,000 correos/mes gratis)
- **Resend**: https://resend.com/ (3,000 correos/mes gratis)

---

## 🔧 IMPLEMENTACIÓN ACTUAL

### Archivos creados:

1. **`app/Services/PostmarkService.php`**
   - Servicio para enviar correos con Postmark
   - Métodos: `sendEmail()`, `sendTemplatedEmail()`, `testConnection()`

2. **`app/Services/ActiveCampaignService.php`**
   - Método actualizado: `sendTransactionalEmail()` ahora muestra advertencia
   - Método nuevo: `sendEmailViaAutomation()` para disparar automatizaciones

### Plantillas de correo existentes:

- `resources/views/emails/user-created.blade.php` (correo al usuario)
- `resources/views/emails/admin-user-created.blade.php` (correo al admin)

---

## 📝 CÓDIGO DE EJEMPLO

### Usando Postmark (recomendado):

```php
use App\Services\PostmarkService;
use App\Services\ActiveCampaignService;

// 1. Crear contacto en ActiveCampaign
$ac = new ActiveCampaignService();
$ac->createOrUpdateContact([
    'email' => $user->email,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
]);

// 2. Enviar correo con Postmark
$postmark = new PostmarkService();

// Correo al usuario
$postmark->sendEmail([
    'to' => $user->email,
    'subject' => 'Bienvenido a Laravel',
    'html' => view('emails.user-created', [
        'user' => $user,
        'password' => $password
    ])->render()
]);

// Correo al admin
$postmark->sendEmail([
    'to' => config('mail.from.address'),
    'subject' => 'Nuevo Usuario Registrado',
    'html' => view('emails.admin-user-created', [
        'user' => $user
    ])->render()
]);
```

### Usando ActiveCampaign Automations:

```php
use App\Services\ActiveCampaignService;

$ac = new ActiveCampaignService();

// 1. Crear contacto
$ac->createOrUpdateContact([
    'email' => $user->email,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
]);

// 2. Disparar automatización
$ac->sendEmailViaAutomation(
    email: $user->email,
    automationId: 123, // Reemplazar con tu ID de automatización
    data: [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'password' => $password
    ]
);
```

---

## 🎯 RECOMENDACIÓN FINAL

**Usar Postmark** es la mejor opción porque:

1. ✅ Es especializado en correos transaccionales
2. ✅ Entrega inmediata y garantizada
3. ✅ Fácil de configurar
4. ✅ 100 correos gratis/mes (suficiente para empezar)
5. ✅ Mantienes ActiveCampaign para CRM y automatizaciones de marketing
6. ✅ Separas correos transaccionales de correos de marketing (mejor práctica)

**ActiveCampaign** es mejor para:
- Campañas de marketing
- Secuencias automáticas de seguimiento
- Gestión de contactos y CRM
- NO para correos transaccionales (bienvenida, reset password, etc.)

---

## 🔗 RECURSOS

- **Postmark**: https://postmarkapp.com/
- **Documentación Postmark API**: https://postmarkapp.com/developer
- **ActiveCampaign Automations**: https://help.activecampaign.com/hc/en-us/articles/221842887
- **Laravel Mail**: https://laravel.com/docs/mail

---

## ❓ PREGUNTAS FRECUENTES

**Q: ¿Por qué no funciona ActiveCampaign para correos transaccionales?**
A: Su API v3 no soporta envío directo. Solo puede hacerlo mediante automatizaciones configuradas en su panel.

**Q: ¿Puedo usar Gmail para enviar correos?**
A: No recomendado. Gmail tiene límites estrictos (100-500 correos/día) y puede marcar tus correos como spam.

**Q: ¿Cuánto cuesta Postmark?**
A: 100 correos/mes gratis, luego $1.25 por cada 1,000 correos.

**Q: ¿Necesito configurar DNS?**
A: Sí, para verificar tu dominio y mejorar la entrega. Postmark te guía en el proceso.

