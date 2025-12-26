<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario Registrado</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 40px 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="max-width: 600px; background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); padding: 50px 40px; text-align: center; border-radius: 20px 20px 0 0;">
                            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
                                <span style="font-size: 40px;">🔔</span>
                            </div>
                            <h1 style="margin: 0; color: white; font-size: 32px; font-weight: 700;">Nuevo Usuario Registrado</h1>
                            <p style="margin: 15px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">Se ha creado una nueva cuenta</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 10px 0; color: #1a202c; font-size: 24px; font-weight: 600;">Información del Usuario 👤</h2>
                            <p style="margin: 0 0 30px 0; color: #4a5568; font-size: 16px; line-height: 1.6;">Un nuevo usuario ha sido registrado en Human and Job.</p>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%); border-radius: 16px; margin: 30px 0; border: 1px solid #fc8181;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding-bottom: 20px;">
                                                    <span style="display: inline-block; width: 50px; height: 50px; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); border-radius: 12px; text-align: center; line-height: 50px; font-size: 24px; margin-right: 15px;">👤</span>
                                                    <span style="color: #2d3748; font-size: 20px; font-weight: 600;">Datos del Usuario</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table cellpadding="8" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">👤 Nombre</td>
                                                <td style="color: #2d3748; font-size: 14px; text-align: right; padding: 8px 0;">{{ $user->first_name }} {{ $user->second_name }} {{ $user->last_name }} {{ $user->second_last_name }}</td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #fc8181; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">📧 Email</td>
                                                <td style="color: #2d3748; font-size: 14px; text-align: right; padding: 8px 0;">{{ $user->email }}</td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #fc8181; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">🔑 Contraseña</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <span style="background: white; color: #ff6b6b; padding: 8px 16px; border-radius: 8px; font-family: 'Courier New', monospace; font-size: 16px; font-weight: 700; border: 2px dashed #ff6b6b;">{{ $temporaryPassword }}</span>
                                                </td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #fc8181; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">🎭 Rol</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <span style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-transform: capitalize;">{{ ucfirst($user->rol) }}</span>
                                                </td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #fc8181; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">📅 Fecha</td>
                                                <td style="color: #2d3748; font-size: 14px; text-align: right; padding: 8px 0;">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr><td colspan="2" style="border-bottom: 1px solid #fc8181; padding: 0;"></td></tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; font-weight: 600; padding: 8px 0;">🆔 ID</td>
                                                <td style="color: #2d3748; font-size: 14px; text-align: right; padding: 8px 0;">#{{ $user->id }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: #e6fffa; border-left: 4px solid #38b2ac; border-radius: 12px; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0; color: #234e52; font-size: 14px; line-height: 1.6;">
                                            <span style="font-size: 18px;">✅</span> <strong>Acciones:</strong>
                                        </p>
                                        <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #234e52; font-size: 14px;">
                                            <li>Usuario creado</li>
                                            <li>Sincronizado en ActiveCampaign</li>
                                            <li>Correo de bienvenida enviado</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; text-decoration: none; padding: 18px 50px; border-radius: 50px; font-size: 16px; font-weight: 600; box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);">📊 Ver Dashboard</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f7fafc; padding: 40px; text-align: center; border-top: 1px solid #e2e8f0; border-radius: 0 0 20px 20px;">
                            <p style="margin: 0 0 15px 0; color: #a0aec0; font-size: 12px;">© {{ date('Y') }} Human and Job - Admin</p>
                            <p style="margin: 0; color: #cbd5e0; font-size: 11px;">info@humanandjob.com</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
