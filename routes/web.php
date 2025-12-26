<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use Postmark\PostmarkClient;

Route::get('/', function () {
    return view('welcome');
});

// Dev Test Route: create a test user to verify email notifications (remove after testing)
Route::get('/dev/create-user', function () {
    $input = [
        'first_name' => 'Dev',
        'second_name' => 'Test',
        'last_name' => 'User',
        'second_last_name' => null,
        'email' => 'dev.test+' . time() . '@humanandjob.com',
        'rol' => 'profesional',
        'password' => 'Test12345!',
        'password_confirmation' => 'Test12345!'
    ];

    $action = new \App\Actions\Fortify\CreateNewUser();
    $user = $action->create($input);

    return response()->json(['created' => true, 'user' => $user->email]);
});

// Ruta de prueba directa con Postmark
Route::get('/test-postmark-direct', function () {
    try {
        $client = new PostmarkClient("36217846-9f36-4404-8a75-9e4836ced169");
        
        $sendResult = $client->sendEmail(
            "info@humanandjob.com",          // From
            "fbotasso@wessexschool.cl",      // To
            "Test desde Postmark PHP",        // Subject
            "<strong>¡Hola!</strong> Este es un correo de prueba desde Postmark PHP.", // HTML
            "Hola! Este es un correo de prueba desde Postmark PHP.", // Text
            "test-email",                     // Tag
            true,                             // Track Opens
            NULL,                             // Reply To
            NULL,                             // CC
            NULL,                             // BCC
            NULL,                             // Headers
            NULL,                             // Attachments
            "None",                           // Track Links
            NULL,                             // Metadata
            "outbound"                        // Message Stream
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Correo enviado exitosamente',
            'messageId' => $sendResult->messageid,
            'to' => $sendResult->to,
            'submittedAt' => $sendResult->submittedat,
            'instructions' => 'Revisa tu bandeja en fbotasso@wessexschool.cl y también el Activity de Postmark'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User Management Routes
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-suspend', [UserManagementController::class, 'toggleSuspend'])->name('users.toggle-suspend');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/restore', [UserManagementController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{user}/force', [UserManagementController::class, 'forceDestroy'])->name('users.force-destroy');
});

Route::post('/dashboard/register-user', [UserController::class, 'store'])->name('dashboard.register-user');
