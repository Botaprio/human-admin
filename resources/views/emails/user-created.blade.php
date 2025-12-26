<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a Human and Job!</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 40px 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="max-width: 600px; background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 40px; text-align: center; border-radius: 20px 20px 0 0;">
                            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px; text-align: center;">
                                <span style="font-size: 40px;">👋</span>
                            </div>
                            <h1 style="margin: 0; color: white; font-size: 32px; font-weight: 700;">
                                ¡Bienvenido a Human and Job!
                            </h1>
                            <p style="margin: 15px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                Tu cuenta profesional ha sido creada
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 10px 0; color: #1a202c; font-size: 24px; font-weight: 600;">
                                Hola {{ $user->first_name }} 👏
                            </h2>
                            <p style="margin: 0 0 30px 0; color: #4a5568; font-size: 16px; line-height: 1.6;">
                                Nos emociona tenerte como parte de nuestra plataforma de profesionales. Aquí encontrarás las mejores oportunidades para hacer crecer tu carrera.
                            </p>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius: 16px; margin: 30px 0; border: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding-bottom: 20px;">
                                                    <span style="display: inline-block; width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; text-align: center; line-height: 50px; font-size: 24px; vertical-align: middle; margin-right: 15px;">🔐</span>
                                                    <span style="color: #2d3748; font-size: 20px; font-weight: 600; vertical-align: middle;">Tus Credenciales de Acceso</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table cellpadding="8" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">📧 Email</td>
                                                <td style="color: #2d3748; font-size: 14px; text-align: right; padding: 8px 0;">{{ $user->email }}</td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #e2e8f0; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">🔑 Contraseña</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <span style="background: white; color: #667eea; padding: 8px 16px; border-radius: 8px; font-family: 'Courier New', monospace; font-size: 16px; font-weight: 700; border: 2px dashed #667eea;">{{ $temporaryPassword }}</span>
                                                </td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #e2e8f0; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">👤 Rol</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-transform: capitalize;">{{ ucfirst($user->rol) }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 12px; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                                            <span style="font-size: 18px;">⚠️</span> <strong>Importante:</strong> Por tu seguridad, te recomendamos cambiar tu contraseña inmediatamente después de iniciar sesión por primera vez.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="https://profesionales.humanandjob.com" target="_blank" rel="noopener noreferrer" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; padding: 18px 50px; border-radius: 50px; font-size: 16px; font-weight: 600; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);">🚀 Iniciar Sesión Ahora</a>
                                    </td>
                                </tr>
                            </table>
                            <h3 style="margin: 40px 0 20px 0; color: #2d3748; font-size: 18px; font-weight: 600; text-align: center;">¿Qué puedes hacer en Human and Job?</h3>
                            <table cellpadding="10" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td width="33%" align="center">
                                        <div style="background: #f7fafc; border-radius: 12px; padding: 20px;">
                                            <div style="font-size: 32px; margin-bottom: 10px;">💼</div>
                                            <p style="margin: 0; color: #4a5568; font-size: 13px; font-weight: 600;">Encontrar Oportunidades</p>
                                        </div>
                                    </td>
                                    <td width="33%" align="center">
                                        <div style="background: #f7fafc; border-radius: 12px; padding: 20px;">
                                            <div style="font-size: 32px; margin-bottom: 10px;">📊</div>
                                            <p style="margin: 0; color: #4a5568; font-size: 13px; font-weight: 600;">Gestionar tu Perfil</p>
                                        </div>
                                    </td>
                                    <td width="33%" align="center">
                                        <div style="background: #f7fafc; border-radius: 12px; padding: 20px;">
                                            <div style="font-size: 32px; margin-bottom: 10px;">🎯</div>
                                            <p style="margin: 0; color: #4a5568; font-size: 13px; font-weight: 600;">Crecer Profesionalmente</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 40px 0 0 0;">
                                <tr>
                                    <td style="text-align: center;">
                                        <p style="margin: 0 0 10px 0; color: #718096; font-size: 14px;">¿Necesitas ayuda? Estamos aquí para ti</p>
                                        <p style="margin: 0;"><a href="mailto:info@humanandjob.com" style="color: #667eea; text-decoration: none; font-weight: 600;">info@humanandjob.com</a></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f7fafc; padding: 40px; text-align: center; border-top: 1px solid #e2e8f0; border-radius: 0 0 20px 20px;">
                            <p style="margin: 0 0 15px 0; color: #a0aec0; font-size: 12px;">© {{ date('Y') }} Human and Job. Todos los derechos reservados.</p>
                            <p style="margin: 0; color: #cbd5e0; font-size: 11px;">Este correo fue enviado a {{ $user->email }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
