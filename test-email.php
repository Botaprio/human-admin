<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DE POSTMARK ===\n\n";

// Test 1: Con la librería directa de Postmark
echo "1. Probando con Postmark Client directo...\n";
try {
    $client = new \Postmark\PostmarkClient("36217846-9f36-4404-8a75-9e4836ced169");
    
    $result = $client->sendEmail(
        "info@humanandjob.com",
        "fbotasso@wessexschool.cl",
        "Test Directo Postmark",
        "<strong>Este correo fue enviado directamente con Postmark Client</strong>",
        "Este correo fue enviado directamente con Postmark Client",
        "test-direct",
        true,
        NULL, NULL, NULL, NULL, NULL,
        "None",
        NULL,
        "outbound"
    );
    
    echo "✅ Correo enviado con Postmark Client\n";
    echo "   Message ID: " . $result->messageid . "\n";
    echo "   To: " . $result->to . "\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: Con Laravel Mail
echo "2. Probando con Laravel Mail...\n";
try {
    Illuminate\Support\Facades\Mail::raw(
        'Este correo fue enviado con Laravel Mail + Postmark',
        function($message) {
            $message->to('fbotasso@wessexschool.cl')
                    ->subject('Test Laravel Mail + Postmark');
        }
    );
    
    echo "✅ Correo enviado con Laravel Mail\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

echo "=== REVISA TU BANDEJA EN: fbotasso@wessexschool.cl ===\n";
echo "=== Y EL ACTIVITY DE POSTMARK ===\n";
