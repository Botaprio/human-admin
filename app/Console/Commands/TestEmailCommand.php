<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\UserCreatedNotification;
use App\Mail\AdminUserCreatedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {--user-id=1 : ID del usuario para usar en la prueba} {--to= : Email de destino}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía correos de prueba para verificar la configuración de email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando prueba de envío de correos...');
        $this->newLine();

        // Obtener usuario de prueba
        $userId = $this->option('user-id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("❌ No se encontró el usuario con ID: {$userId}");
            return Command::FAILURE;
        }

        $this->info("👤 Usuario seleccionado: {$user->name} ({$user->email})");
        $this->newLine();

        // Email de destino
        $toEmail = $this->option('to') ?: $user->email;
        $password = 'Password123!';

        // Confirmar envío
        if (!$this->confirm("¿Deseas enviar correos de prueba a {$toEmail}?", true)) {
            $this->warn('Operación cancelada.');
            return Command::SUCCESS;
        }

        $this->newLine();
        $bar = $this->output->createProgressBar(2);
        $bar->start();

        try {
            // Enviar correo al usuario
            $this->info('📧 Enviando correo de bienvenida al usuario...');
            Mail::to($toEmail)->send(new UserCreatedNotification($user, $password));
            $bar->advance();
            $this->newLine();
            $this->info('✅ Correo de usuario enviado correctamente');

            // Enviar correo al admin
            $this->info('📧 Enviando notificación al administrador...');
            $adminEmail = config('mail.admin_address');
            Mail::to($adminEmail)->send(new AdminUserCreatedNotification($user, 'test123'));
            $bar->advance();
            $this->newLine();
            $this->info('✅ Correo de administrador enviado correctamente');

            $bar->finish();
            $this->newLine(2);

            $this->info('🎉 Prueba completada exitosamente!');
            $this->table(
                ['Tipo', 'Destinatario', 'Estado'],
                [
                    ['Usuario', $toEmail, '✅ Enviado'],
                    ['Admin', $adminEmail, '✅ Enviado'],
                ]
            );

            $this->newLine();
            $this->comment('💡 Revisa tu bandeja de entrada (y spam) en los próximos minutos.');
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $bar->finish();
            $this->newLine(2);
            $this->error('❌ Error al enviar correos: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Verifica la configuración SMTP en tu archivo .env');
            
            return Command::FAILURE;
        }
    }
}
