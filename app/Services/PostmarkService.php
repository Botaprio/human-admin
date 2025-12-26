<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostmarkService
{
    private string $serverToken;
    private string $apiUrl = 'https://api.postmarkapp.com';

    public function __construct()
    {
        $this->serverToken = config('services.postmark.token');
    }

    /**
     * Enviar correo transaccional usando Postmark
     */
    public function sendEmail(array $emailData): bool
    {
        try {
            $message = [
                'From' => $emailData['from'] ?? config('mail.from.address'),
                'To' => $emailData['to'],
                'Subject' => $emailData['subject'],
                'HtmlBody' => $emailData['html'] ?? '',
                'TextBody' => $emailData['text'] ?? strip_tags($emailData['html'] ?? ''),
                'MessageStream' => 'outbound' // Para correos transaccionales
            ];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Postmark-Server-Token' => $this->serverToken,
            ])->post("{$this->apiUrl}/email", $message);

            if ($response->successful()) {
                Log::info('Correo enviado exitosamente via Postmark', [
                    'to' => $emailData['to'],
                    'subject' => $emailData['subject'],
                    'message_id' => $response->json()['MessageID'] ?? null
                ]);
                return true;
            }

            Log::error('Error al enviar correo via Postmark', [
                'to' => $emailData['to'],
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al enviar correo via Postmark', [
                'to' => $emailData['to'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Enviar correo con plantilla de Postmark
     */
    public function sendTemplatedEmail(string $to, int $templateId, array $templateData): bool
    {
        try {
            $message = [
                'From' => config('mail.from.address'),
                'To' => $to,
                'TemplateId' => $templateId,
                'TemplateModel' => $templateData,
                'MessageStream' => 'outbound'
            ];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Postmark-Server-Token' => $this->serverToken,
            ])->post("{$this->apiUrl}/email/withTemplate", $message);

            if ($response->successful()) {
                Log::info('Correo con plantilla enviado via Postmark', [
                    'to' => $to,
                    'template_id' => $templateId,
                    'message_id' => $response->json()['MessageID'] ?? null
                ]);
                return true;
            }

            Log::error('Error al enviar correo con plantilla via Postmark', [
                'to' => $to,
                'template_id' => $templateId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al enviar correo con plantilla via Postmark', [
                'to' => $to,
                'template_id' => $templateId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Verificar conexión con Postmark
     */
    public function testConnection(): bool
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Postmark-Server-Token' => $this->serverToken,
            ])->get("{$this->apiUrl}/server");

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Error al verificar conexión con Postmark', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
