<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

App\Models\User::create([
    'name' => 'Test Editor',
    'email' => 'editor@test.com',
    'password' => bcrypt('password123'),
    'role' => 'editor',
    'is_approved' => true,
]);

echo "Editor user created successfully!\n";
