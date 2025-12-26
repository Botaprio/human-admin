<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Mail\UserCreatedNotification;
use App\Mail\AdminUserCreatedNotification;
use App\Services\ActiveCampaignService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'second_last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rol' => ['required', 'in:admin,profesional,empresa'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Guardamos la contraseña en texto plano temporalmente para enviarla por correo
        $plainPassword = $input['password'];

        $user = User::create([
            'first_name' => $input['first_name'],
            'second_name' => $input['second_name'] ?? null,
            'last_name' => $input['last_name'],
            'second_last_name' => $input['second_last_name'] ?? null,
            'email' => $input['email'],
            'rol' => $input['rol'],
            'password' => Hash::make($plainPassword),
        ]);

        // Inicializar servicio de ActiveCampaign
        $activeCampaign = new ActiveCampaignService();

        // Sincronizar contacto con ActiveCampaign
        $contact = $activeCampaign->createOrUpdateContact([
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name . ($user->second_last_name ? ' ' . $user->second_last_name : ''),
            'phone' => $user->phone_number ?? '',
            'custom_fields' => [
                ['field' => '1', 'value' => $user->rol],
            ]
        ]);

        // Enviar correos usando ActiveCampaign API
        $this->sendEmailsViaActiveCampaign($user, $plainPassword, $activeCampaign);

        return $user;
    }

    /**
     * Enviar correos usando Postmark
     * NOTA: ActiveCampaign NO soporta correos transaccionales directos
     * Lee INSTRUCCIONES_CORREOS.md para configurar Postmark o usar automatizaciones
     */
    protected function sendEmailsViaActiveCampaign(User $user, string $password, ActiveCampaignService $activeCampaign): void
    {
        try {
            // Opción A: Usar Postmark (RECOMENDADO)
            if (config('services.postmark.token')) {
                $postmark = new \App\Services\PostmarkService();
                
                // Renderizar vistas de correo
                $userEmailHtml = view('emails.user-created', [
                    'user' => $user,
                    'password' => $password
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

                // Enviar correo al administrador (usar la dirección admin configurada)
                $adminEmail = config('mail.admin_address');
                if ($adminEmail) {
                    $postmark->sendEmail([
                        'to' => $adminEmail,
                        'subject' => 'Nuevo Usuario Registrado - Human and Job',
                        'html' => $adminEmailHtml,
                    ]);
                }
                
                return;
            }

            // Opción B: Usar automatización de ActiveCampaign
            // Primero debes crear la automatización en el panel de ActiveCampaign
            // Luego reemplaza los IDs con los de tus automatizaciones
            
            // $activeCampaign->sendEmailViaAutomation(
            //     email: $user->email,
            //     automationId: 123, // ID de tu automatización de bienvenida
            //     data: [
            //         'first_name' => $user->first_name,
            //         'last_name' => $user->last_name,
            //         'password' => $password
            //     ]
            // );

            // Fallback: usar el sistema tradicional de Laravel
            \Log::warning('Postmark no configurado, usando Laravel Mail como fallback. Lee INSTRUCCIONES_CORREOS.md');

            Mail::to($user->email)->send(new UserCreatedNotification($user, $password));
            
            $adminEmail = config('mail.admin_address');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminUserCreatedNotification($user, $temporaryPassword));
            }

        } catch (\Exception $e) {
            \Log::error('Error al enviar correos', [
                'error' => $e->getMessage(),
                'user' => $user->email
            ]);

            // Último recurso: Laravel Mail
            try {
                Mail::to($user->email)->send(new UserCreatedNotification($user, $password));
                
                $adminEmail = config('mail.admin_address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminUserCreatedNotification($user, $temporaryPassword));
                }
            } catch (\Exception $mailException) {
                \Log::error('Falló el envío de correos completamente', [
                    'error' => $mailException->getMessage()
                ]);
            }
        }
    }
}
