<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PostmarkService;

class TestPostmarkCommand extends Command
{
    protected $signature = 'postmark:test {email?}';
    protected $description = 'Probar conexión y envío de correo con Postmark';

    public function handle()
    {
        $postmark = new PostmarkService();

        // Verificar configuración
        if (!config('services.postmark.token')) {
            $this->error('❌ Token de Postmark no configurado!');
            $this->info('');
            $this->info('Agrega esto en tu archivo .env:');
            $this->info('POSTMARK_TOKEN=tu-token-aqui');
            $this->info('');
            $this->info('Obtén tu token en: https://account.postmarkapp.com/servers');
            return 1;
        }

        $this->info('✅ Token de Postmark configurado');
        $this->info('');

        // Verificar conexión
        $this->info('🔍 Verificando conexión con Postmark...');
        if ($postmark->testConnection()) {
            $this->info('✅ Conexión exitosa con Postmark!');
        } else {
            $this->error('❌ Error de conexión con Postmark');
            $this->info('Verifica que tu token sea correcto');
            return 1;
        }

        $this->info('');

        // Enviar correo de prueba
        $email = $this->argument('email') ?? config('mail.from.address');
        
        if (!$email) {
            $this->error('❌ No se especificó correo de prueba');
            $this->info('Uso: php artisan postmark:test email@example.com');
            return 1;
        }

        $this->info("📧 Enviando correo de prueba a: {$email}");

        $result = $postmark->sendEmail([
            'to' => $email,
            'subject' => 'Correo de Prueba - Postmark',
            'html' => view('emails.test', [
                'message' => 'Este es un correo de prueba desde Postmark',
                'timestamp' => now()->format('Y-m-d H:i:s')
            ])->render()
        ]);

        if ($result) {
            $this->info('✅ Correo enviado exitosamente!');
            $this->info('');
            $this->info('Revisa tu bandeja de entrada (y spam si no lo ves)');
            return 0;
        }

        $this->error('❌ Error al enviar correo');
        $this->info('Revisa los logs para más detalles: storage/logs/laravel.log');
        return 1;
    }
}
