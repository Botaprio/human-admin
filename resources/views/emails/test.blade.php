<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }
        .header {
            background: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .success {
            background: #10B981;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .info {
            background: #EFF6FF;
            border-left: 4px solid #3B82F6;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 ¡Postmark Funciona!</h1>
        </div>

        <div class="success">
            ✅ Tu configuración de Postmark está correcta
        </div>

        <div class="info">
            <p><strong>Mensaje:</strong></p>
            <p>{{ $message }}</p>
            
            <p><strong>Enviado:</strong></p>
            <p>{{ $timestamp }}</p>
        </div>

        <p>Si recibes este correo, significa que:</p>
        <ul>
            <li>✅ Tu token de Postmark es válido</li>
            <li>✅ La conexión con Postmark funciona</li>
            <li>✅ Tu dominio está configurado correctamente</li>
            <li>✅ Los correos se están entregando</li>
        </ul>

        <p><strong>Próximos pasos:</strong></p>
        <ol>
            <li>Verifica que tu dominio esté validado en Postmark</li>
            <li>Configura los registros SPF y DKIM en tu DNS</li>
            <li>¡Empieza a enviar correos transaccionales!</li>
        </ol>

        <div class="footer">
            <p>Este es un correo de prueba desde {{ config('app.name') }}</p>
            <p>Enviado via Postmark - https://postmarkapp.com</p>
        </div>
    </div>
</body>
</html>
