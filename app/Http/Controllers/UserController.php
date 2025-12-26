<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreatedNotification;
use App\Mail\AdminUserCreatedNotification;
use App\Services\ActiveCampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Handle the creation of a new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rol' => 'required|string|in:admin,profesional,empresa',
            'password' => 'required|string|min:8',
        ]);

        // Guardamos la contraseña en texto plano temporalmente para enviarla por correo
        $plainPassword = $request->password;

        $user = User::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($plainPassword),
        ]);

        // Inicializar servicio de ActiveCampaign
        $activeCampaign = new ActiveCampaignService();

        // Sincronizar contacto con ActiveCampaign
        $activeCampaign->createOrUpdateContact([
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name . ($user->second_last_name ? ' ' . $user->second_last_name : ''),
            'phone' => $user->phone_number ?? '',
            'custom_fields' => [
                ['field' => '1', 'value' => $user->rol],
            ]
        ]);

        // Enviar correos usando ActiveCampaign API
        try {
            // Renderizar vistas de correo
            // Opción A: Usar Postmark (RECOMENDADO)
            if (config('services.postmark.token')) {
                $postmark = new \App\Services\PostmarkService();
                
                $userEmailHtml = view('emails.user-created', [
                    'user' => $user,
                    'password' => $plainPassword
                ])->render();

                $adminEmailHtml = view('emails.admin-user-created', [
                    'user' => $user
                ])->render();

                // Enviar correo al usuario
                $postmark->sendEmail([
                    'to' => $user->email,
                    'subject' => 'Bienvenido a Human and Job',
                    'html' => $userEmailHtml,
                ]);

                // Enviar correo al administrador (usar la dirección de admin configurada)
                $adminEmail = config('mail.admin_address');
                if ($adminEmail) {
                    $postmark->sendEmail([
                        'to' => $adminEmail,
                        'subject' => 'Nuevo Usuario Registrado - Human and Job',
                        'html' => $adminEmailHtml,
                    ]);
                }
            } else {
                // Fallback: usar Laravel Mail
                \Log::warning('Postmark no configurado, usando Laravel Mail. Lee INSTRUCCIONES_CORREOS.md');
                
                Mail::to($user->email)->send(new UserCreatedNotification($user, $plainPassword));
                
                $adminEmail = config('mail.admin_address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminUserCreatedNotification($user, $temporaryPassword));
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error al enviar correos', [
                'error' => $e->getMessage(),
                'user' => $user->email
            ]);

            // Último recurso: Laravel Mail
            try {
                Mail::to($user->email)->send(new UserCreatedNotification($user, $plainPassword));
                
                $adminEmail = config('mail.admin_address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminUserCreatedNotification($user, $plainPassword));
                }
            } catch (\Exception $mailException) {
                \Log::error('Falló el envío de correos completamente', [
                    'error' => $mailException->getMessage()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Usuario creado con éxito! Se han enviado correos de notificación.');
    }
}
