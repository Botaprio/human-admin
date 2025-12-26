<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ActiveCampaignService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.activecampaign.url');
        $this->apiKey = config('services.activecampaign.api_key');
    }

    /**
     * Crear o actualizar un contacto en ActiveCampaign
     */
    public function createOrUpdateContact(array $contactData): ?array
    {
        try {
            // Primero intentamos buscar si el contacto ya existe
            $existingContact = $this->getContactByEmail($contactData['email']);

            if ($existingContact) {
                // Si existe, actualizamos
                return $this->updateContact($existingContact['id'], $contactData);
            }

            // Si no existe, creamos uno nuevo
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/contacts", [
                'contact' => [
                    'email' => $contactData['email'],
                    'firstName' => $contactData['first_name'] ?? '',
                    'lastName' => $contactData['last_name'] ?? '',
                    'phone' => $contactData['phone'] ?? '',
                    'fieldValues' => $contactData['custom_fields'] ?? [],
                ]
            ]);

            if ($response->successful()) {
                Log::info('Contacto creado en ActiveCampaign', [
                    'email' => $contactData['email'],
                    'response' => $response->json()
                ]);
                return $response->json();
            }

            Log::error('Error al crear contacto en ActiveCampaign', [
                'email' => $contactData['email'],
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Excepción al crear contacto en ActiveCampaign', [
                'email' => $contactData['email'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Actualizar un contacto existente
     */
    public function updateContact(int $contactId, array $contactData): ?array
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->put("{$this->apiUrl}/api/3/contacts/{$contactId}", [
                'contact' => [
                    'email' => $contactData['email'],
                    'firstName' => $contactData['first_name'] ?? '',
                    'lastName' => $contactData['last_name'] ?? '',
                    'phone' => $contactData['phone'] ?? '',
                    'fieldValues' => $contactData['custom_fields'] ?? [],
                ]
            ]);

            if ($response->successful()) {
                Log::info('Contacto actualizado en ActiveCampaign', [
                    'email' => $contactData['email'],
                    'contact_id' => $contactId
                ]);
                return $response->json();
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Error al actualizar contacto en ActiveCampaign', [
                'contact_id' => $contactId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Agregar un tag a un contacto
     */
    public function addTagToContact(int $contactId, int $tagId): bool
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/contactTags", [
                'contactTag' => [
                    'contact' => $contactId,
                    'tag' => $tagId
                ]
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Error al agregar tag en ActiveCampaign', [
                'contact_id' => $contactId,
                'tag_id' => $tagId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Obtener información de un contacto por email
     */
    public function getContactByEmail(string $email): ?array
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
            ])->get("{$this->apiUrl}/api/3/contacts", [
                'email' => $email
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['contacts'][0] ?? null;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Error al buscar contacto en ActiveCampaign', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Crear una lista en ActiveCampaign
     */
    public function createList(string $name, string $stringid): ?array
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/lists", [
                'list' => [
                    'name' => $name,
                    'stringid' => $stringid,
                    'sender_url' => config('app.url'),
                    'sender_reminder' => 'Has recibido este correo porque te registraste en ' . config('app.name'),
                ]
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Error al crear lista en ActiveCampaign', [
                'name' => $name,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Suscribir un contacto a una lista
     */
    public function subscribeContactToList(int $contactId, int $listId, int $status = 1): bool
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/contactLists", [
                'contactList' => [
                    'list' => $listId,
                    'contact' => $contactId,
                    'status' => $status // 1 = active, 2 = unsubscribed
                ]
            ]);

            if ($response->successful()) {
                Log::info('Contacto suscrito a lista en ActiveCampaign', [
                    'contact_id' => $contactId,
                    'list_id' => $listId
                ]);
                return true;
            }

            Log::error('Error al suscribir contacto a lista', [
                'contact_id' => $contactId,
                'list_id' => $listId,
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al suscribir contacto a lista', [
                'contact_id' => $contactId,
                'list_id' => $listId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Probar la conexión con ActiveCampaign
     */
    public function testConnection(): array
    {
        try {
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
            ])->get("{$this->apiUrl}/api/3/lists", [
                'limit' => 1
            ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'message' => $response->successful() 
                    ? 'Conexión exitosa con ActiveCampaign' 
                    : 'Error de conexión: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 0,
                'message' => 'Excepción: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Enviar un correo transaccional usando ActiveCampaign
     * NOTA: ActiveCampaign API v3 NO soporta envío directo de correos transaccionales.
     * Este método dispara una automatización que debe estar configurada en ActiveCampaign.
     * 
     * Alternativa: Usar servicios como Postmark, SendGrid, Mailgun o Amazon SES
     */
    public function sendTransactionalEmail(array $emailData): ?array
    {
        Log::warning('ActiveCampaign API v3 NO soporta envío directo de correos transaccionales', [
            'to' => $emailData['to'],
            'subject' => $emailData['subject']
        ]);

        // El endpoint /messages solo REGISTRA mensajes, NO los envía
        // Para enviar correos reales, debes:
        // 1. Usar automatizaciones de ActiveCampaign
        // 2. Usar un servicio de correos transaccionales (Postmark, SendGrid, etc.)
        
        return null;
    }

    /**
     * Enviar correo disparando una automatización de ActiveCampaign
     * Debes crear la automatización en el panel de ActiveCampaign primero
     */
    public function sendEmailViaAutomation(string $email, int $automationId, array $data = []): bool
    {
        try {
            // Primero aseguramos que el contacto exista
            $contact = $this->getContactByEmail($email);
            
            if (!$contact) {
                // Crear el contacto si no existe
                $contactResult = $this->createOrUpdateContact([
                    'email' => $email,
                    'first_name' => $data['first_name'] ?? '',
                    'last_name' => $data['last_name'] ?? '',
                ]);
                
                if ($contactResult && isset($contactResult['contact']['id'])) {
                    $contact = $contactResult['contact'];
                } else {
                    Log::error('No se pudo crear contacto para enviar correo', [
                        'email' => $email
                    ]);
                    return false;
                }
            }

            // Disparar la automatización
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/contactAutomations", [
                'contactAutomation' => [
                    'contact' => $contact['id'],
                    'automation' => $automationId
                ]
            ]);

            if ($response->successful()) {
                Log::info('Automatización de correo disparada en ActiveCampaign', [
                    'email' => $email,
                    'automation_id' => $automationId,
                    'contact_id' => $contact['id']
                ]);
                return true;
            }

            Log::error('Error al disparar automatización de correo', [
                'email' => $email,
                'automation_id' => $automationId,
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al disparar automatización de correo', [
                'email' => $email,
                'automation_id' => $automationId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Disparar una automatización para un contacto
     */
    public function triggerAutomation(string $email, int $automationId): bool
    {
        try {
            // Primero obtenemos el contacto
            $contact = $this->getContactByEmail($email);
            
            if (!$contact) {
                Log::warning('No se pudo disparar automatización: contacto no encontrado', [
                    'email' => $email
                ]);
                return false;
            }

            // Disparamos la automatización
            $response = Http::withHeaders([
                'Api-Token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/3/contactAutomations", [
                'contactAutomation' => [
                    'contact' => $contact['id'],
                    'automation' => $automationId
                ]
            ]);

            if ($response->successful()) {
                Log::info('Automatización disparada en ActiveCampaign', [
                    'email' => $email,
                    'automation_id' => $automationId,
                    'contact_id' => $contact['id']
                ]);
                return true;
            }

            Log::error('Error al disparar automatización', [
                'email' => $email,
                'automation_id' => $automationId,
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al disparar automatización', [
                'email' => $email,
                'automation_id' => $automationId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
