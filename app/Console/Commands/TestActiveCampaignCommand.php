<?php

namespace App\Console\Commands;

use App\Services\ActiveCampaignService;
use Illuminate\Console\Command;

class TestActiveCampaignCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activecampaign:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba la conexión con ActiveCampaign y verifica la configuración';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Probando conexión con ActiveCampaign...');
        $this->newLine();

        // Verificar configuración
        $url = config('services.activecampaign.url');
        $apiKey = config('services.activecampaign.api_key');

        if (!$url || !$apiKey) {
            $this->error('❌ Configuración incompleta!');
            $this->warn('Verifica que ACTIVECAMPAIGN_URL y ACTIVECAMPAIGN_API_KEY estén en tu .env');
            return Command::FAILURE;
        }

        $this->info("📍 URL: {$url}");
        $this->info("🔑 API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -10));
        $this->newLine();

        // Probar conexión
        $service = new ActiveCampaignService();
        $result = $service->testConnection();

        if ($result['success']) {
            $this->info('✅ ' . $result['message']);
            $this->newLine();
            
            // Probar creación de contacto
            if ($this->confirm('¿Deseas crear un contacto de prueba?', false)) {
                $email = $this->ask('Email del contacto de prueba', 'test@example.com');
                $firstName = $this->ask('Primer nombre', 'Test');
                $lastName = $this->ask('Apellido', 'User');

                $this->info('📤 Creando contacto en ActiveCampaign...');
                
                $contact = $service->createOrUpdateContact([
                    'email' => $email,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);

                if ($contact) {
                    $this->info('✅ Contacto creado exitosamente!');
                    $this->table(
                        ['Campo', 'Valor'],
                        [
                            ['ID', $contact['contact']['id'] ?? 'N/A'],
                            ['Email', $contact['contact']['email'] ?? 'N/A'],
                            ['Nombre', ($contact['contact']['firstName'] ?? '') . ' ' . ($contact['contact']['lastName'] ?? '')],
                        ]
                    );
                } else {
                    $this->error('❌ Error al crear el contacto');
                    $this->warn('Revisa los logs en storage/logs/laravel.log');
                }
            }

            // Probar envío de correo transaccional
            if ($this->confirm('¿Deseas probar el envío de un correo transaccional?', false)) {
                $toEmail = $this->ask('Email de destino', config('mail.from.address'));
                
                $this->info('📧 Enviando correo de prueba via ActiveCampaign...');
                
                $result = $service->sendTransactionalEmail([
                    'to' => $toEmail,
                    'subject' => 'Correo de Prueba - ' . config('app.name'),
                    'html' => '<h1>¡Hola!</h1><p>Este es un correo de prueba enviado desde <strong>' . config('app.name') . '</strong> usando la API de ActiveCampaign.</p><p>Fecha: ' . now()->format('d/m/Y H:i:s') . '</p>',
                ]);

                if ($result) {
                    $this->info('✅ Correo enviado exitosamente!');
                    $this->comment('Revisa la bandeja de entrada de: ' . $toEmail);
                } else {
                    $this->error('❌ Error al enviar el correo');
                    $this->warn('Revisa los logs en storage/logs/laravel.log');
                }
            }
            
            return Command::SUCCESS;
        } else {
            $this->error('❌ Error de conexión');
            $this->warn('Status: ' . $result['status']);
            $this->warn('Mensaje: ' . $result['message']);
            $this->newLine();
            $this->comment('💡 Verifica:');
            $this->line('  - Que la URL de la API sea correcta');
            $this->line('  - Que la API Key sea válida');
            $this->line('  - Que tengas conexión a internet');
            
            return Command::FAILURE;
        }
    }
}
